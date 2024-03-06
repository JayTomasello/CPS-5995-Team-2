from flask import Flask, render_template, request
import pymongo
import dbconfig
from dbconfig import myclient
from dbconfig import mydb
import random
import string

app = Flask(__name__)

# Connect to MongoDB
mycol = mydb["sub_user"]


print("""
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD4NJ Registration</title>
    <link rel="icon" href="./NJLawDigest Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container align-middle justify-content-center" style="background-image: url(./Courthouse.jpg); background-size:cover; background-position:center -100px">
    <h3 class="text-center" style="margin-top: 50px; font-family:Georgia, 'Times New Roman', Times, serif">By Xavier Amparo, Matthew Fernandez, Eric Landaverde, Julio Rodriguez, and Joseph Tomasello</h3>
    <form class="text-center m-5" action="/register.py" method="POST">
        <h1 class="card-title" style="font-family:Georgia, 'Times New Roman', Times, serif">Law Digest 4 New Jersey</h1>
        <div class="mb-3">
            <input name="Email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter Email" required>
        </div>
        <div class="mb-3">
            <input name="Password" type="password" class="form-control" placeholder="Enter Password" required>
        </div>
        <div class="mb-3">
            <input name="Confirm_Password" type="password" class="form-control" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>
""")

app = Flask(__name__)

# Connect to MongoDB
mycol = mydb["sub_user"]

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/register', methods=['POST'])
def register():
    email = request.form['Email']
    password = request.form['Password']
    confirm_password = request.form['Confirm_Password']

    # Check if passwords match
    if password != confirm_password:
        return "<h2>Passwords do not match</h2>"
    else:
        # Check if password meets criteria
        if len(password) < 8 or not any(c.isupper() for c in password) or not any(c.isdigit() for c in password) or not any(c in '!@#$%^&*()_+-=[]{}|;:,.<>?`~' for c in password):
            return "<h2>Password must be at least 8 characters long and contain at least one uppercase letter, one number, and one special character.</h2>"
        else:
            # Generate random token
            token = ''.join(random.choices(string.ascii_letters + string.digits, k=16))

            # Save user data to MongoDB
            user_data = {
                "email": email,
                "password": password,
                "token": token,
                "status": "pending"  # Initial status set to 'pending'
            }
            mycol.insert_one(user_data)
            return "<h2 class='text-center'>Account created successfully! We have sent a confirmation email to your address.</h2>"

if __name__ == '__main__':
    app.run(debug=True)



app = Flask(__name__)