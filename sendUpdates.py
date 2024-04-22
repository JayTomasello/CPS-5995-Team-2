import smtplib
from email.mime.text import MIMEText
from supabase import create_client, Client

def send_update_email(subject, message, destination, sender_email, sender_password):
    """Send an email update."""
    msg = MIMEText(message, 'plain')
    msg['Subject'] = subject

    with smtplib.SMTP('smtp-mail.outlook.com', 587) as server:
        server.starttls()
        server.login(sender_email, sender_password)
        server.sendmail(sender_email, destination, msg.as_string())

def fetch_user_subjects(supabase, user_id):
    """Fetch subjects subscribed by a user."""
    sub_response = supabase.table('user_subject').select('subject').eq('uid', user_id).execute()
    return [row['subject'] for row in sub_response.data]

def fetch_bill_updates(supabase, subject):
    """Fetch bill updates for a subject."""
    alert_response = supabase.table('alert_table').select('*').eq('bill_subject', subject).execute()
    return alert_response.data

def fetch_bill_details(supabase, subject, bill_number, bill_session):
    """Fetch details of a bill."""
    bill_response = supabase.table('law_table2').select('bill_synopsis').eq('subject', subject)\
                     .eq('bill_number', bill_number).eq('session', bill_session).execute()
    return bill_response.data

if __name__ == "__main__":
    # Supabase Connection
    supabase_url = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    supabase_key =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase_client = create_client(supabase_url, supabase_key)

    sender_email = 'ridinonall4s@msn.com'
    sender_password = 'legomaster535'

    user_ids = set()
    uid_response = supabase_client.table('user_subject').select('uid').execute()
    for row in uid_response.data:
        user_ids.add(row['uid'])

    for user_id in user_ids:
        subjects = fetch_user_subjects(supabase_client, user_id)
        message = ""
        for subject in subjects:
            bill_updates = fetch_bill_updates(supabase_client, subject)
            if not bill_updates:
                message += f"Saved Subject: {subject}\n0 Bill Updates\n\n"
            else:
                for update in bill_updates:
                    message += f"Saved Subject: {subject}\n{update['bills_total']} Bill Updates\n\n"
                    for i, bill_number in enumerate(update['bill_numbers'], start=1):
                        bill_details = fetch_bill_details(supabase_client, subject, bill_number, update['bill_session'])
                        for detail in bill_details:
                            message += f"{i}. Bill Number: {bill_number} | Session: {update['bill_session']}\nBill Synopsis: {detail['bill_synopsis']}\n\n"
                    message += "\n"
        message += "\nBest,\nYour friends at LD4NJ"
        user_email_response = supabase_client.table('sub_user').select('email').eq('uid', user_id).execute()
        for row in user_email_response.data:
            send_update_email("LD4NJ - Legislative Updates Notification", message, row['email'], sender_email, sender_password)
