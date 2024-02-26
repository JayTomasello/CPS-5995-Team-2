from flask import Flask
import dbconfig.py as db

app = flask(__name__)


@app.route('/login.php', methods=['GET', 'POST'])
def login():
    response = supabase.table('users').select('*').execute()
    return response
