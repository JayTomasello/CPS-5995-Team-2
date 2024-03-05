import sys, os
from supabase import create_client, Client
import hashlib
import sys

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
        return 'Invalid email: Mo Email Provided'
    

if __name__ == "__main__":
    # Supabase Connection
    url: str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    key: str =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase: Client = create_client(url, key)

    args = sys.argv[1:]
    email = args[0]
    password = args[1]

    response = userRegistration(supabase, email, password, "sampletoken")
    print(response)