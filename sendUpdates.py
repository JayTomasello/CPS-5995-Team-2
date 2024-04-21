import smtplib, ssl
from email.mime.text import MIMEText
from random import randrange
import sys
from supabase import create_client, Client

# def send_email_gmail(subject, message, destination):
#     # First assemble the message
#     msg = MIMEText(message, 'plain')
#     msg['Subject'] = subject

#     # Login and send the message
#     port = 587
#     my_mail = 'ridinonall4s@msn.com'
#     my_password = 'legomaster535'
#     with smtplib.SMTP('smtp-mail.outlook.com', port) as server:
#         server.starttls()
#         server.login(my_mail, my_password)
#         server.sendmail(my_mail, destination, msg.as_string())

if __name__ == "__main__":
    # Supabase Connection
    url: str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    key: str =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase: Client = create_client(url, key)

    response = supabase.table('user_subject').select('uid', 'subject').execute()

    for row in response.data:
        print(row['uid'])

    # message = 'Your Verification Code: ' + str(acct_verif_code)
    # send_email_gmail('LD4NJ - Automated Bill Update', message, eml)
    # print(acct_verif_code)