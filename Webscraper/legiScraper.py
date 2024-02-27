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
import pandas as pd
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait, Select
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
import time
from selenium.common.exceptions import WebDriverException



# Set up Chrome options for headless mode
chrome_options = Options()
chrome_options.add_argument("--headless")  # Ensures the browser runs in headless mode
chrome_options.add_argument('--no-sandbox')
chrome_options.add_argument('--disable-dev-shm-usage')

# Path to your chromedriver executable
chromedriver_path = r"C:\Users\effra\Downloads\ChromeDriver_Selenium\chromedriver.exe"

service = Service(executable_path=chromedriver_path)
driver = webdriver.Chrome(service=service, options=chrome_options)


def setup_driver():
    """Sets up the WebDriver."""
    # Set up Chrome options for headless mode
    chrome_options = Options()
    chrome_options.add_argument("--headless")  # Ensures the browser runs in headless mode
    chrome_options.add_argument('--no-sandbox')
    chrome_options.add_argument('--disable-dev-shm-usage')

    # Path to your chromedriver executable
    chromedriver_path = r"C:\Users\effra\Downloads\ChromeDriver_Selenium\chromedriver.exe"

    service = Service(executable_path=chromedriver_path)
    driver = webdriver.Chrome(service=service, options=chrome_options)
    return driver


def main_logic(driver):
    """Main logic to perform operations with the driver."""


    data = []  # Initialize a list to store data dictionaries

    driver.get('https://www.njleg.state.nj.us/bill-search')
    
    ####  CHECK IF SUBJECT AND SESSION EXIST  ####
    try:
        # Wait for the session and subject dropdowns to load
        WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, 'Session')))
        WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, 'Subject')))
    except WebDriverException:
        print("Session and/or subject dropdowns did not load. Refreshing the page...")
        driver.get(driver.current_url)
        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Session')))
        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Subject')))

    #### HANDLE PRINTING OF SESSION AND SUBJECT DROPDOWNS  ####
    # Handle Session Dropdown
    session_dropdown = Select(driver.find_element(By.ID, 'Session'))
    print("Sessions available:")
    for option in session_dropdown.options:
        print(f"- {option.text}")

    # Handle Subject Dropdown
    subject_dropdown = Select(driver.find_element(By.ID, 'Subject'))
    print("\nSubjects available:")
    for option in subject_dropdown.options:
        print(f"- {option.text}")


    ####  ITERATE OVER SESSIONS AND SUBJECTS  ####        
    for session_index in range(len(session_dropdown.options)):

        # Re-fetch the session dropdown at the start of each loop to avoid stale references
        session_dropdown = Select(driver.find_element(By.ID, 'Session'))
        session_option = session_dropdown.options[session_index]
        print(f"Session option: {session_option.text}")
        
        session_value = session_option.get_attribute('value')
        if session_value:  # Skip the placeholder if present
            session_dropdown.select_by_value(session_value)

            subject_dropdown = None
            try:
                # After selecting a session, refetch the subject dropdown to ensure it's not stale
                WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Subject')))
                subject_dropdown = Select(driver.find_element(By.ID, 'Subject'))
            except WebDriverException:
                print("Subject dropdown is stale. Refreshing the page... Location 1")
                driver.get(driver.current_url)
                WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Subject')))




            
            for subject_index in range(len(subject_dropdown.options)):


                #### HANDLE SUBJECT DROPDOWN  ####
                subject_value = None
                try:
                    # Re-fetch the subject dropdown at the start of each inner loop
                    subject_dropdown = Select(driver.find_element(By.ID, 'Subject'))
                    subject_option = subject_dropdown.options[subject_index]
                    subject_value = subject_option.get_attribute('value')
                    subject_text = subject_option.text
                    print(f"Subject option: {subject_text}")
                except WebDriverException:
                    print("Subject dropdown is stale. Refreshing the page... Location 2")
                    driver.get(driver.current_url)
                    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Subject')))
                    subject_dropdown = Select(driver.find_element(By.ID, 'Subject'))
                    subject_option = subject_dropdown.options[subject_index]
                    subject_value = subject_option.get_attribute('value')
                    subject_text = subject_option.text
                
                if subject_value:  # Skip placeholder
                    try: 
                        subject_dropdown.select_by_value(subject_value)
                        print(f"Current URL {driver.current_url}")
                        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'Session')))
                        session_dropdown = Select(driver.find_element(By.ID, 'Session'))
                        session_dropdown.select_by_value(session_value)  # Re-select the current session
                    except WebDriverException:
                        print("Subject dropdown is stale. Refreshing the page... Location 3")


                        # Wait for the 'Search' button to be clickable
                    WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.ID, 'Search')))
                    # Find the 'Search' button
                    search_button = driver.find_element(By.ID, 'Search')
                    # Print the text of the button
                    if search_button.text == 'SUBMIT':  # Replace with the actual text on the button
                        search_button.click()
                        print("The button found has the expected text.")
                    else:
                        print("The button found does not have the expected text.")

                    time.sleep(5)
                
                    #bill_collection = []
                    
                   # Wait for the pagination container to appear
                    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CLASS_NAME, 'bsearch-pagination_paginationCenter__us1DL')))

                    # Locate all the pagination buttons within the container
                    pagination_buttons = driver.find_elements(By.CSS_SELECTOR, '.bsearch-pagination_paginationCenter__us1DL > button')

                    # IMPLEMENT PAGE NUMBER CHECK FOR RESULTS

                    for i in range(len(pagination_buttons)):
                        # Re-identify the pagination buttons to avoid stale element reference errors
                        pagination_buttons = driver.find_elements(By.CSS_SELECTOR, '.bsearch-pagination_paginationCenter__us1DL > button')
                        pagination_button = pagination_buttons[i]
                        
                        # Click the pagination button
                        pagination_button.click()


                        # Wait for the bill list to load
                        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'billList')))

                        # Locate the billList div
                        bill_list_div = driver.find_element(By.ID, 'billList')

                        # Find all <ul> tags within the billList div
                        bill_ul_tags = bill_list_div.find_elements(By.TAG_NAME, 'ul')

                        print(f"Number of bills on page {i + 1}: {len(bill_ul_tags)}")

                        # Initialize a list to hold all collected bill information
                        bills_info = []

                       
                        bill_links = [bill_ul.find_element(By.CLASS_NAME, 'main-bill-search_billNumber__EWhqA').get_attribute('href') for bill_ul in bill_ul_tags]

                        search_url = driver.current_url

                        # Iterate over each <ul> to extract bill information
                        for bill_ul in bill_ul_tags:

                            print(f"Current URL while navigating bills {driver.current_url}")
                            bill_info = {}

                            # Extract the bill number and URL
                            bill_info['session'] = session_value
                            bill_info['subject'] = subject_text
                            bill_number_element = bill_ul.find_element(By.CLASS_NAME, 'main-bill-search_billNumber__EWhqA')
                            bill_info['bill_number'] = bill_number_element.text.strip()
                            bill_info['url'] = bill_number_element.get_attribute('href')
                            
                            # Extract the synopsis
                            synopsis_element = bill_ul.find_element(By.CLASS_NAME, 'main-bill-search_synopsis__h4mlL')
                            bill_info['synopsis'] = synopsis_element.text.strip()
                            
                            # Attempt to extract the last session bill number and identical bill number, if present
                            label_elements = bill_ul.find_elements(By.CLASS_NAME, 'main-bill-search_label__mWbTn')
                            for label_element in label_elements:
                                if "Last Session Bill Number" in label_element.text:
                                    bill_info['last_session_bill_number'] = label_element.find_element(By.TAG_NAME, 'a').text.strip()
                                elif "Identical Bill Number" in label_element.text:
                                    bill_info['identical_bill_number'] = label_element.find_element(By.TAG_NAME, 'a').text.strip()

                            # Navigate to the bill text page and extract the bill text
                            driver.get(bill_info['url'])

                            
                            bill_url = driver.current_url
                            print(f"Bill URL: {bill_url}")

                                ####  NAVIGATE TO HTML BILL ####

                            try:

                                # Wait for the HTML format link to be clickable
                                html_link = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "//a[contains(@class, 'bill-text_billDocLink__ptXXl') and contains(text(), 'HTML Format')]")))
                                # Click the HTML format link
                                html_link.click()
                                # Wait for the URL to change to the new page with HTML format
                                print(driver.current_url)
                                # Store the new URL and print it
                                new_url = driver.current_url
                                print(f"The URL after clicking the HTML format link is: {new_url}")
                            except Exception as e:
                                print(f"An error occurred while navigating to bill page: {e}")


                            


                            try:    
                                #Wait for the div with class 'WordSection3' to be present
                                WebDriverWait(driver, 10).until(
                                    EC.presence_of_element_located((By.CLASS_NAME, "WordSection3"))
                                )

                                # Find the div with class 'WordSection3'
                                word_section_div = driver.find_element(By.CLASS_NAME, "WordSection3")

                                # Find all p tags with class 'MsoNormal' within the div
                                mso_normal_elements = word_section_div.find_elements(By.CLASS_NAME, "MsoNormal")

                                # Extract the text from each p tag
                                bill_texts = [element.text for element in mso_normal_elements if element.text.strip() != '']

                                # Concatenate all the text into one large string
                                bill_info["bill_text"] = ' '.join(bill_texts)
                            except Exception as e:
                                print("Bill text extraction failed.")


                            #data.append({'session': session_value, 'subject': subject_text, 'data': })
                            
                            # Collect number of pages

                            # Iterate over the pages

                            # Collect bill data from each page

                            # Append to data list

                            # Navigate to next page

                            # Repeat until all pages are collected

                                    
                            # Navigate to search url to avoid stale element reference errors
                            driver.get(search_url)
                            print(f" Bll Info: {bill_info}")
                            bills_info.append(bill_info)
                            print(f"Current URL {driver.current_url}")

                        data.extend(bills_info)

    df = pd.DataFrame(data)
    
    return df


max_retries = 10  # Maximum number of retries
attempts = 0     # Current attempt

while attempts < max_retries:
    driver = setup_driver()  # Initialize WebDriver outside try-except to ensure it's accessible in finally
    try:
        df = main_logic(driver)  # Attempt to execute main logic and collect data
        #df = pd.DataFrame(data)  # Convert collected data to DataFrame
        print(df)  # Optionally print or process the DataFrame
        break  # Break the loop if operation was successful
    except Exception as e:  # Catching a general exception for simplicity; refine as needed
        print(f"An error occurred: {e}")
        attempts += 1
        print(f"Attempt {attempts} of {max_retries}. Retrying...")
        time.sleep(5)
    finally:
        driver.quit()  # Properly close the WebDriver session

if attempts == max_retries:
    print("Maximum retries reached. Exiting program.")