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


def userLogin(supabase, email, password):

    if email:
         if password:
             # Set a cookie to remember the user
            h_password = hash_password(password)
            response = None
            try : 
                response = supabase.table('sub_user').select('email', 'password').eq('email', email).execute()
            except:
                return 'User not found'
            if response.data[0]['password'] == h_password:
                
                return 'Correct password'
            else:
                return 'Incorrect password'
                
         else:
             return 'Invalid password: No Password Provided'
    else:
        return 'Invalid email: No Email Provided'
    

if __name__ == "__main__":
    # Supabase Connection
    url: str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    key: str =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase: Client = create_client(url, key)

    args = sys.argv[1:]
    email = args[0]
    password = args[1]

    response = userLogin(supabase, email, password)
    print(response)