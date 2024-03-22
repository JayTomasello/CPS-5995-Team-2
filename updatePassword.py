from supabase import create_client, Client
import hashlib
import sys

def updateUserPassword(supabase, email, new_password):
    if email:
        if new_password:
            # Check if user with given email exists
            response = supabase.table("sub_user").select("*").eq("email", email).execute()
            if response.data[0]:
                # User exists, update password
                # Encode the password string to bytes
                password_bytes = new_password.encode('utf-8')

                # Create a SHA-256 hash object
                sha256_hash = hashlib.sha256()

                # Update the hash object with the password bytes
                sha256_hash.update(password_bytes)

                # Get the hexadecimal representation of the hashed password
                hashed_password = sha256_hash.hexdigest()
                data = {"password": hashed_password}
                update_response = supabase.table("sub_user").update(data).eq("email", email).execute()
                return 'Password updated successfully'
            else:
                return 'User with email {} does not exist'.format(email)
        else:
            return 'Invalid new password: No password provided'
    else:
        return 'Invalid email: No email provided'

if __name__ == "__main__":
    # Supabase Connection
    url: str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    key: str =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase: Client = create_client(url, key)

    args = sys.argv[1:]
    email = args[0]
    new_password = args[1]

    response = updateUserPassword(supabase, email, new_password)
    print(response)
