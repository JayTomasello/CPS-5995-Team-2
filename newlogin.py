from flask import Flask, render_template, request, redirect
import pymongo
import dbconfig

app = Flask(__name__)

# Connect to MongoDB
mycol = dbconfig.mydb["sub_user"]

@app.route('/')
def index():
    return """
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LD4NJ Login</title>
    <link rel="icon" href="./NJLawDigest Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        if ( window.history.replaceState ) {{
            window.history.replaceState( null, null, window.location.href );
        }}
    </script>
</head>
<body class="container align-middle justify-content-center" style="background-image: url(./Courthouse.jpg); background-size:cover; background-position:center -100px">
    <h3 class="text-center" style="margin-top: 50px; font-family:Georgia, 'Times New Roman', Times, serif">By Xavier Amparo, Matthew Fernandez, Eric Landaverde, Julio Rodriguez, and Joseph Tomasello</h3>
    <form class="text-center m-5" action="/login" method="POST">
        <h1 class="card-title" style="font-family:Georgia, 'Times New Roman', Times, serif">Law Digest 4 New Jersey</h1>
        <div class="mb-3">
            <input name="Email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter Email" required>
        </div>
        <div class="mb-3">
            <input name="Password" type="password" class="form-control" placeholder="Enter Password" required>
        </div>
        <a type="button" class="btn btn-secondary mx-2" href="./newpass.php">Forgot Password?</a>
        <a type="button" class="btn btn-secondary mx-2" href="./register.py">Sign Up</a>
        <button name="login" type="submit" value="submit" class="btn btn-primary mx-5">Submit</button>
    </form>
</body>
</html>
"""

@app.route('/login', methods=['POST'])
def login():
    email = request.form.get('Email')
    password = request.form.get('Password')

    # Authenticate user
    user = mycol.find_one({"email": email, "password": password})
    if user:
        # Redirect user to the index page
        return redirect("/index.php")  # Replace with the path to your index page
    else:
        return "<h2 class='text-center'>Invalid email or password</h2>"

@app.route('/forgot_password')
def forgot_password():
    # Redirect user to the forgot password page
    return redirect("/newpass.php")  # Replace with the path to your forgot password page

if __name__ == '__main__':
    app.run(debug=True)