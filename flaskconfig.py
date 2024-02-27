from flask import Flask
from flask_mail import Mail, Message
from supabase import create_client
import hashlib

app = Flask(__name__)

# Supabase Connection
NEXT_PUBLIC_SUPABASE_URL = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
NEXT_PUBLIC_SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
supabase = create_client(NEXT_PUBLIC_SUPABASE_URL,
                         NEXT_PUBLIC_SUPABASE_ANON_KEY)

# Mailtrap Connection
app.config['MAIL_SERVER'] = 'smtp.gmail.com'
app.config['MAIL_PORT'] = 587
app.config['MAIL_USERNAME'] = 'matthewfernandez0@gmail.com'
app.config['MAIL_PASSWORD'] = '$yZal$%3PT8U0e2fDLn2'
app.config['MAIL_USE_TLS'] = True
app.config['MAIL_USE_SSL'] = False
mail = Mail(app)

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


def send_confirmation_email(email):
    token = app.secrets.token_urlsafe(16)  # Generate a random token
    supabase.table('ld4nj.sub_user').insert(
        {'email': email, 'confirmation_token': token}).execute()  # Store token in Supabase

    msg = Message('Confirm Your Email',
                  sender='noreply@lawdigestNJ.com', recipients=[email])
    msg.body = f'Please click the following link to confirm your email: {url_for('confirm_token.php', token=token, _external=True)}'
    mail.send(msg)


@app.route('/register', methods=['POST'])
def register():
    email = app.request.form['Email']
    password = app.request.form['Password']
    password2 = app.request.form['Confirm Password']

    if password != password2:
        return 'Passwords do not match'

    # Check if email is already registered
    user_exists = supabase.table('ld4nj.sub_user').select(
        'email').eq('email', email).execute()

    if user_exists:
        return 'Email already registered'
    else:
        # Register the user (you should hash the password before storing it)
        supabase.table('ld4nj.sub_user').insert(
            {'email': email, 'password': password}).execute()
        send_confirmation_email(email)
        return 'Registration successful. Please check your email to confirm your account.'


@app.route('/confirm/<token>')
def confirm_email(token):
    # Verify the token and update user's account status as confirmed
    # This step is omitted for brevity
    return 'Email confirmed successfully'


if __name__ == '__main__':
    app.run(debug=True)
