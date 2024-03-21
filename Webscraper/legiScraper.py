from selenium.webdriver.support.ui import WebDriverWait, Select
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import WebDriverException, NoSuchElementException
import logging
import time
from supabase import create_client
import pandas as pd
from selenium import webdriver
from selenium.webdriver.support.ui import Select
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
import selenium.webdriver.support.ui as ui
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import os
import pandas as pd
from sqlalchemy import create_engine, MetaData, Table, Column, Integer, String, select, update
from sqlalchemy.orm import sessionmaker
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait, Select
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
import time
from supabase import create_client, Client
import logging
from multiprocessing import Pool



# Setup logger
logger = logging.getLogger(__name__)
logging.basicConfig(level=logging.INFO)

def setup_driver():
    """Sets up the WebDriver."""
    options = webdriver.FirefoxOptions()
    options.add_argument('--headless') 
    driver = webdriver.Firefox(options=options)
    return driver

def reinitialize_driver(driver):
    """Quits the current WebDriver instance and initializes a new one."""
    try:
        driver.quit()
    except Exception:
        pass  # Ignore errors when quitting the driver
    driver = setup_driver()
    return driver

def store_last_scraped_info(session, subject):
    with open("last_scraped.txt", "w") as file:
        file.write(f"{session},{subject}")



def load_last_scraped_info():
    try:
        with open("last_scraped.txt", "r") as file:
            session, subject = file.read().split(',')
            return session, subject
    except FileNotFoundError:
        return None, None
    
def generate_remaining_bill_search_data(driver, last_session, last_subject):
    sessions_subjects_pairs = generate_bill_search_data(driver)
    if last_session is None and last_subject is None:
        return sessions_subjects_pairs  # No last session/subject, return full list

    remaining_sessions_subjects_pairs = {}
    session_found = False

    for session in sessions_subjects_pairs:
        if session_found or session == last_session:
            subjects_list = sessions_subjects_pairs[session]
            if session == last_session:
                subject_index = subjects_list.index(last_subject) + 1
                if subject_index < len(subjects_list):
                    remaining_sessions_subjects_pairs[session] = subjects_list[subject_index:]
                    session_found = True
                continue  # Move to the next session after processing last subject in a session
            remaining_sessions_subjects_pairs[session] = subjects_list
            session_found = True

    return remaining_sessions_subjects_pairs

def navigate_to_search_page(driver):
    """Navigates to the bill search page and ensures the dropdowns are loaded."""
    driver.get('https://www.njleg.state.nj.us/bill-search')
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Session')))
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Subject')))
    logger.info("Session and subject dropdowns loaded successfully.")

def generate_bill_search_data(driver):
    """Generates a dictionary containing session values as keys and lists of subject values as values."""
    sessions_subjects_pairs = {}
    # Wait for the session dropdown to load
    #WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Session')))
    navigate_to_search_page(driver)
    session_dropdown = Select(driver.find_element(By.ID, 'Session'))
    # Iterate over each session option
    for session_option in session_dropdown.options:
        session_value = session_option.get_attribute('value')
        # Skip the placeholder option
        if session_value:
            session_dropdown.select_by_value(session_value)  # Select the session to load its subjects
            time.sleep(2)  # Wait for subjects to load based on session selection
            # Wait for the subject dropdown to load
            WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Subject')))
            subject_dropdown = Select(driver.find_element(By.ID, 'Subject'))
            subjects_list = []
            # Iterate over each subject option
            for subject_option in subject_dropdown.options:
                subject_value = subject_option.get_attribute('value')
                # Skip the placeholder option
                if subject_value:
                    subjects_list.append(subject_value)
            sessions_subjects_pairs[session_value] = subjects_list
    return sessions_subjects_pairs



def select_session_and_subject(driver, session_value, subject_value):
    """Selects a specific session and subject based on provided values."""
            #### HANDLE SUBJECT DROPDOWN  ####
    logger.info(f"Current Browser URL: {driver.current_url}")
    navigate_to_search_page(driver)
    try:
        # Wait for the subject dropdown to refresh after selecting the session
        subject_dropdown = Select(driver.find_element(By.ID, 'Subject'))
        #WebDriverWait(driver, 10).until(EC.staleness_of(subject_dropdown.first_selected_option))
        subject_dropdown.select_by_value(subject_value)
    except WebDriverException as e:
        logger.warning(f"Subject dropdown is stale. Refreshing the page... Location 2. Webdriver error {e}")

    try: 
        session_dropdown = Select(driver.find_element(By.ID, 'Session'))
        #WebDriverWait(driver, 10).until(EC.staleness_of(session_dropdown.first_selected_option))
        session_dropdown.select_by_value(session_value)
    except WebDriverException as e:
        logger.warning(f"Session dropdown is stale. Refreshing the page... Location 3. Webdriver error {e}")

    logger.info(f"Selected session '{session_value}' and subject '{subject_value}'.")
    logger.info("Clicking the search button...")
    search_button = driver.find_element(By.ID, 'Search')
    search_button.click()
    # Check if the search button was clicked by verifying the presence of the bill list


def scrape_bills(driver, session_value, subject_value):
    """Clicks the search button and scrapes bill information."""
    bills_info = []
    while True:
        bill_ul_tags = None
        try:
            WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'billList')))
            # Locate the billList div
            bill_list_div = driver.find_element(By.ID, 'billList')
            # Find all <ul> tags within the billList div
            bill_ul_tags = bill_list_div.find_elements(By.TAG_NAME, 'ul')
        except WebDriverException as e:
            logger.warning(f"Bill list did not load. Refreshing the page... Location 4. Webdriver error {e}")
            driver.get(driver.current_url)
            WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'billList')))
            bill_list_div = driver.find_element(By.ID, 'billList')
            bill_ul_tags = bill_list_div.find_elements(By.TAG_NAME, 'ul')   
        logger.info(f"Number of bills on page: {len(bill_ul_tags)}")
        for bill_ul in bill_ul_tags:
            bill_info = {}
            bill_url = bill_ul.find_element(By.CLASS_NAME, 'main-bill-search_billNumber__EWhqA').get_attribute('href')
            bill_number = bill_ul.find_element(By.CLASS_NAME, 'main-bill-search_billNumber__EWhqA').text
            bill_info['session'] = session_value
            bill_info['subject'] = subject_value
            bill_info['bill_url'] = bill_url
            bill_info['bill_number'] = bill_number
            bills_info.append(bill_info)
            #logger.info(f"Scraped {len(bill_info)} bills for {session_value} and {subject_value}.")
        # Check for and click on the next page button, if it exists
        try:
            if driver.find_element(By.XPATH, "//a[contains(@class, 'bsearch-pagination_next__ZACwL')]").is_displayed():
                logger.info(f"Navigating to the next page for {session_value} and {subject_value}.")
                # Corrected XPath to match the actual 'Next' button based on its class
                next_page_button = driver.find_element(By.XPATH, "//a[contains(@class, 'bsearch-pagination_next__ZACwL')]")
                next_page_button.click()
                #logger.info("Navigated to the next page.")
                time.sleep(2)  # Adjust sleep time as necessary for page loading
            else:
                logger.warning("No more pages to process.")
                break
        except NoSuchElementException as e:
            logger.warning("No page button found. Exiting loop.")
            break  # No more pages to process
    logger.info(f"Finished scraping bills for session '{session_value}' and subject '{subject_value}'. Number of bills scraped: {len(bills_info)}")
    return bills_info


def supaUpload(data):
    url : str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    key : str = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase: Client = create_client(url, key)
    logger.info("Uploading data to Supabase...")
    response = None
    try:
        response = supabase.table('dummy_table2').insert(data).execute()
        logger.info("Data uploaded successfully.")
    except Exception as e:
        logger.warning(f"Upload failed. Exception: {e}")
    return response

def billText(driver, data):
    max_retries = 3

    for bill_info in data:
        url = bill_info['bill_url']
        attempts = 0
        bill_text = ""

        while attempts < max_retries:
            try:
                driver.get(url)
                # Navigate to HTML bill
                html_link = WebDriverWait(driver, 10).until(
                    EC.element_to_be_clickable((By.XPATH, "//a[contains(@class, 'bill-text_billDocLink__ptXXl') and contains(text(), 'HTML Format')]"))
                )
                html_link.click()
                new_url = driver.current_url
                logger.info(f"Successful navigation to bill page. The URL after clicking the HTML format link is: {new_url}")
                
                # Extract bill text
                WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CLASS_NAME, "WordSection3")))
                word_section_div = driver.find_element(By.CLASS_NAME, "WordSection3")
                mso_normal_elements = word_section_div.find_elements(By.CLASS_NAME, "MsoNormal")
                bill_text = ' '.join([element.text for element in mso_normal_elements if element.text.strip() != ''])
                bill_info["bill_text"] = bill_text
                break  # Success, exit loop
            except (NoSuchElementException, WebDriverException) as e:
                logger.warning(f"Attempt {attempts + 1} for URL {url} failed with error: {e}")
                if attempts >= max_retries - 1:
                    logger.error(f"Max retries reached for URL {url}. Skipping.")
                    bill_info["bill_text"] = None
                    break  # Exit loop on max retries
            except Exception as e:
                logger.error(f"Unexpected error for URL {url}: {e}")
                bill_info["bill_text"] = None
                break  # Exit loop on unexpected errors
            finally:
                attempts += 1

    logger.info(f"Size of bill text data: {len(data)}.")
    return data



def main(driver, sessions_subjects_pairs):
    """Main function to setup driver and loop through sessions and subjects to scrape bills."""
    bills_info = []

    try:
        for session_value, subject_values in sessions_subjects_pairs.items():
            for subject_value in subject_values:
                
                select_session_and_subject(driver, session_value, subject_value)
                data = scrape_bills(driver, session_value, subject_value)
                final_data = billText(driver, data)
                try:
                    supaUpload(final_data)
                except Exception as e:
                    logger.warning(f"Upload failed. Exception: {e}")
                bills_info.extend(final_data)
                logger.info(f"Finished scraping bills {len(bills_info)} for session '{session_value}' and subject '{subject_value}'.")
                store_last_scraped_info(session_value, subject_value)
                # Process scraped data or save to file
        return bills_info
    finally:
        driver.quit()

if __name__ == "__main__":
    driver = setup_driver()
    last_session, last_subject = None, None
    sessions_subjects_pairs = None

    last_session, last_subject = load_last_scraped_info()
    logger.info(f"Last scraped session: {last_session}, Last scraped subject: {last_subject}")
    sessions_subjects_pairs = generate_remaining_bill_search_data(driver, last_session, last_subject)

            
    # Example usage with multiple sessions and subjects
    #sessions_subjects_pairs = generate_bill_search_data(driver)

    bills_info = main(driver,sessions_subjects_pairs)

    df = pd.DataFrame(bills_info, index=None)
    df.to_csv("test3.csv", index=False)

    # Delete the last scraped file
    if os.path.exists("last_scraped.txt"):
        os.remove("last_scraped.txt")