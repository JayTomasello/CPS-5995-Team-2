import sys, os
from supabase import create_client, Client
import sys

def userExists(supabase, email):
    response = supabase.table('sub_user').select('password').eq('email', email).execute()
    if response.data[0]:
        return 'User Exists'
    else:
        return 'User Does Not Exist'
    

if __name__ == "__main__":
    # Supabase Connection
    url: str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    key: str =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase: Client = create_client(url, key)

    args = sys.argv[1:]
    email = args[0]

    response = userExists(supabase, email)
    print(response)