from supabase import create_client, Client
import ollama
import sys, os

def generate_answer(user_question, bill_number2, session_filter, subject_search):
    response = None
    try : 
        response = supabase.table('law_table2').select('bill_text').eq('bill_number', bill_number2).eq('session', session_filter).eq('subject', subject_search).execute()
    except:
        return 'Error: Bill text not found.'
    bill_text = response.data[0]['bill_text']

    if user_question is not None:
        response2 = ollama.chat(model="llama2", messages=[
            {
                "role": "user",
                "content": bill_text + "\n\nPrompt: Using the above text, answer the following question in layman's terms: " + user_question,
            },
        ])

    response3 = response2['message']['content']

    response3 = response3.replace("\n", " ")

    return response3
    

if __name__ == "__main__":
    # Supabase Connection
    url: str = 'https://zwmhjgftwvkcdirgvxwj.supabase.co'
    key: str =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp3bWhqZ2Z0d3ZrY2Rpcmd2eHdqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MDkwNTQ2NTAsImV4cCI6MjAyNDYzMDY1MH0.Of7v3vo-zPdfTbN2o9vfk5_U3kEtMUTo1tS-JQDlOmI'
    supabase: Client = create_client(url, key)

    args = sys.argv[1:]
    user_question = args[3]
    user_question = user_question.replace("~~~", " ")
    bill_number2 = args[0]
    bill_number2 = bill_number2.replace("~~~", " ")
    session_filter = args[1]
    session_filter = session_filter.replace("~~~", " ")
    subject_search = args[2]
    subject_search = subject_search.replace("~~~", " ")


    response = generate_answer(user_question, bill_number2, session_filter, subject_search)
    print(response)