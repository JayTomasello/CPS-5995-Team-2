from flask import Flask, request, redirect, url_for, render_template, flash, session
from flask_mail import Mail, Message
from supabase import create_client, Client
import hashlib
import os

app = Flask(__name__)

# Supabase Connection
NEXT_PUBLIC_SUPABASE_URL = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
NEXT_PUBLIC_SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
supabase: Client = create_client(NEXT_PUBLIC_SUPABASE_URL,
                                 NEXT_PUBLIC_SUPABASE_ANON_KEY)

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


# def send_confirmation_email(email, password):
    token = os.urandom(16).hex()  # Generate a random token
#     supabase.table('ld4nj.sub_user').insert(
#         {'email': email, 'password': password, 'confirmation_token': token}).execute()  # Store token in Supabase

#     msg = Message('Confirm Your Email', recipients=[
#                   email], sender='noreply@lawdigestNJ.com', body = f'Please click the following link to confirm your email:{app.url_for("confirm_email", token=token, _external=True)}'
#     Mail.send(msg)


@app.route("/register", methods=['POST', 'GET'])
def register():
    email = request.form['Email']
    password = request.form['Password']

    if request.method == 'POST':
        # Check if email is already registered
        user_exists = supabase.from_('sub_user').select(
            '*').eq('email', email).execute()

        if user_exists:
            return 'Email already registered'
        else:
            hashed_password = hash_password(password)  # Hash the password
            token = os.urandom(16).hex()  # Generate a random token
0
            # Insert user data into the Supabase table
            data, count = supabase.table('sub_user').insert(
                {'email': email, 'password': hashed_password, 'confirmation_token': token}).execute()

        return 


@app.route("/login.php", methods=['POST'])
def login():
    email = request.form['Email']
    password = request.form['Password']

    print("Hello World")

    # # Check if user exists:
    # user = supabase.table('ld4nj.sub_user').select(
    #     'email', 'password').eq('email', email).execute()

    # if user:
    #     if user['password'] == hash_password(password):
    #         # Set a cookie to remember the user
    #         response = app.make_response('Login successful')
    #         response.set_cookie('signedIn', email)
    #         return response
    #     else:
    #         return 'Invalid password'


@app.route('/confirm_email/<token>')
def confirm_email(token):
    # Verify the token and update user's account status as confirmed
    # This step is omitted for brevity
    return 'Email confirmed successfully'


if __name__ == '__main__':
    app.run(debug=True)
