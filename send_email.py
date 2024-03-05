import smtplib, ssl
from email.mime.text import MIMEText
from random import randrange
import sys

def send_email_gmail(subject, message, destination):
    # First assemble the message
    msg = MIMEText(message, 'plain')
    msg['Subject'] = subject

    # Login and send the message
    port = 587
    my_mail = 'ridinonall4s@msn.com'
    my_password = 'legomaster535'
    with smtplib.SMTP('smtp-mail.outlook.com', port) as server:
        server.starttls()
        server.login(my_mail, my_password)
        server.sendmail(my_mail, destination, msg.as_string())

if __name__ == "__main__":
    acct_verif_code = randrange(100000, 999999)
    args = sys.argv[1:]
    eml = args[0]
    message = 'Your Verification Code: ' + str(acct_verif_code)
    send_email_gmail('LD4NJ - Account Verification Code', message, eml)
    print(acct_verif_code)