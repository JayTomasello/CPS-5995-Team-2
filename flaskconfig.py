from flask import Flask
from flask_mail import Mail, Message
from supabase import create_client

app = Flask(__name__)

# Supabase Connection
user = "postgres.zwmhjgftwvkcdirgvxwj"
password = ['Wereits0easy!']
host = "aws-0-us-east-1.pooler.supabase.com"
port = 5432
dbname = "postgres"
mysqli = MySQLdb.connect(user, password, host, port, dbname)

# Mailtrap Connection
app.config['MAIL_SERVER'] = 'smtp.gmail.com'
app.config['MAIL_PORT'] = 465
app.config['MAIL_USERNAME'] = '836a5ed679be6c'
app.config['MAIL_PASSWORD'] = '93df96778a6e09'
app.config['MAIL_USE_TLS'] = True
app.config['MAIL_USE_SSL'] = False


@app.route('/')
def index():
    return render_template('form.html')


def setcookie():
    response = make_response('Setting a cookie')
    response.set_cookie('username', 'flask', max_age=60*60*24*365*2)
    return response


@app.route('/login.php', methods=['POST'])
def login():
    response = supabase.table('users').select('*').execute()
    return response


@app.route('/newuser.php', methods=['POST'])
def register():
    # Get the email from the request
    email = app.request.form.get('Email')
    pass1 = app.request.form.get('Password')
    pass2 = app.request.form.get('Confirm Password')

    if pass1 != pass2:
        return 'Passwords do not match'
    else:
        return 'Passwords match.  We will send a confirmation email to your address if it exists.'
        # Send confirmation email
        send_email(email, 'Confirm Your Email',
                   'Please click the link to confirm your email.')

        # Return a success message
        return 'Registration successful. Please check your email to confirm your account.'
