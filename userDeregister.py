from supabase import create_client, Client
import hashlib





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



def userDeregister(supabase, email, password, token):

    if email:
         if password:
             # Set a cookie to remember the user
            h_password = hash_password(password)
            response = None
            try : 
                response = supabase.table('sub_user').select('email', 'password').eq('email', email).execute()
            except:
                return 'User not found'
            print(response.data[0]['password'])
            if response.data[0]['password'] == password:
                print("User Exists!")
                data = supabase.table('sub_user').delete().eq('email', email).execute()
                return data
        
            else:
                return 'Incorrect password'
                
         else:
             return 'Invalid password: No Password Provided'
    else:
        return 'Invalid email: Mo Email Provided'
    

        



if __name__ == "__main__":
    # Supabase Connection
    url: str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    key: str =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase: Client = create_client(url, key)
    email = "testemail2@gmail.com"
    password = "1234"
    response = userDeregister(supabase, email, password, "")
    print(response)