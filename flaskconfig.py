from flask import Flask, request, response
from flask_mail import Mail, Message
from supabase import create_client, Client
import hashlib
import os

app = Flask(__name__)

# Supabase Connection
url: str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
key: str = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
supabase: Client = create_client(url, key)

# Gmail Connection
app.config['MAIL_SERVER'] = 'smtp.gmail.com'
app.config['MAIL_PORT'] = 465
app.config['MAIL_USERNAME'] = 'matthewfernandez0@gmail.com'
app.config['MAIL_PASSWORD'] = '$yZal$%3PT8U0e2fDLn2'
app.config['MAIL_USE_TLS'] = True
app.config['MAIL_USE_SSL'] = True
app.config['SECRET_KEY'] = os.urandom(24)  # Generate a secret key for Flask
mail = Mail(app=app)


def hash_password(password):
    # Encode the password string to bytes
    password_bytes = password.encode('utf-8')

    # Create a SHA-256 hash object
    sha256_hash = hashlib.sha256()

    # Update the hash object with the password bytes
    sha256_hash.update(password_bytes)

    # Get the hexadecimal representation of the hashed password
    hashed_password = sha256_hash.hexdigest()

    return hashed_password


@app.route('/register', methods=['POST'])
def userRegistration(supabase, email, password, token):

    if email:
        if password:
            # Set a cookie to remember the user
            h_password = hash_password(password)
            data = {"email": email, "password": h_password, "token": token}
            response = supabase.table("sub_user").insert(data).execute()
            return response
        else:
            return 'Invalid password: No Password Provided'
    else:
        return 'Invalid email: No Email Provided'


@app.route('/login', methods=['POST'])
def userLogin(supabase, email, password):

    if email:
        if password:
            # Set a cookie to remember the user
            h_password = hash_password(password)
            response = None
            try:
                response = supabase.table('sub_user').select(
                    'email', 'password').eq('email', email).execute()
            except:
                return 'User not found'
            print(response.data[0]['password'])
            if response.data[0]['password'] == h_password:
                return response
            else:
                return 'Incorrect password'

        else:
            return 'Invalid password: No Password Provided'
    else:
        return 'Invalid email: Mo Email Provided'


@app.route('/forgot_password', methods=['POST'])
def resetPassword(supabase, email, new_password):
    if email:
        if new_password:
            h_password = hash_password(new_password)
            response = supabase.table('sub_user').update(
                {'password': h_password}).eq('email', email).execute()
            return response
        else:
            return 'Invalid password: No Password Provided'
    else:
        return 'Invalid email: No Email Provided'

@app.route('/logout', methods=['POST'])
def logout():


@app.route('/confirm_email/<token>')
def confirm_email(token):
    # Verify the token and update user's account status as confirmed
    # This step is omitted for brevity
    return 'Email confirmed successfully'


if __name__ == '__main__':
    app.run(debug=True)
