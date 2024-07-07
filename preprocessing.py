# import mysql.connector
# import re
# import string
# from cleantext import clean
# from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
# from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory

# mydb = mysql.connector.connect(
#   host="localhost",
#   user="root",
#   passwd="",
#   database="ta"
# )

# temp = []
# mycursor = mydb.cursor()
# mycursor.execute("SELECT DISTINCT * FROM data_raw")
# myresult = mycursor.fetchall()

# mycursor1 = mydb.cursor()
# mycursor1.execute("SELECT * FROM kamus")
# myresult1 = mycursor.fetchall()

# factory = StemmerFactory()
# stemmer = factory.create_stemmer()

# stop_factory = StopWordRemoverFactory()
# stopword = stop_factory.create_stop_word_remover()

# seen_texts = set()
# #Proses data
# for x in myresult:
#     if x[15] is not None and x[4] is not None:
#         original_text = x[4]
#         if original_text in seen_texts:
#             continue  # Skip jika teks sudah diproses
#         seen_texts.add(original_text)  # Tambahkan ke set
#         #menghapus tag, hastag, link url, space, emoticon, dan tanda baca
#         clean_text = re.sub("@[A-Za-z0-9_]+","", original_text)
#         clean_text = re.sub("#[A-Za-z0-9_]+","", clean_text)
#         clean_text = re.sub(r'http\S+', '', clean_text)
#         clean_text = re.sub("RT : ", "", clean_text)
#         clean_text = " ".join(clean_text.split())
#         clean_text = clean(clean_text, no_emoji=True)
#         clean_text = clean_text.translate(str.maketrans('', '', string.punctuation))

#         #Mengubah kata informal menjadi formal
#         s = ''
#         clean_text = clean_text.split()
        
#         for y in clean_text:
#             for x1 in myresult1:
#                 if y == x1[1] :
#                     y = x1[2]
#             s = s + y + " "
#             clean_text = s 

#         #Stemming
#         clean_text = stemmer.stem(str(clean_text))
#         #Menghapus stopword
#         clean_text = stopword.remove(clean_text)

#         # Memasukkan data teks bersih ke tabel clean_text
#         insert_query = "INSERT INTO proses (username, full_text, processed_text) VALUES (%s, %s, %s)"
#         mycursor.execute(insert_query, (x[15], x[4], clean_text ))
    
#     mydb.commit()

#     # mycursor.execute("SELECT DISTINCT  FROM raw_data")

# import mysql.connector
# import re
# import string
# from cleantext import clean
# from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
# from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory

# # Menyambungkan ke basis data
# mydb = mysql.connector.connect(
#     host="localhost",
#     user="root",
#     passwd="",
#     database="ta"
# )
# cursor = mydb.cursor()

# # Mengambil semua data sekaligus
# cursor.execute("SELECT DISTINCT * FROM data_raw")
# raw_texts = cursor.fetchall()

# cursor.execute("SELECT * FROM kamus")
# kamus = {row[1]: row[2] for row in cursor.fetchall()}

# # Mempersiapkan pola regex
# user_pattern = re.compile("@[A-Za-z0-9_]+")
# hashtag_pattern = re.compile("#[A-Za-z0-9_]+")
# url_pattern = re.compile(r'http\S+')
# rt_pattern = re.compile("RT : ")

# # Menginisialisasi alat pemrosesan bahasa
# stemmer = StemmerFactory().create_stemmer()
# stopword = StopWordRemoverFactory().create_stop_word_remover()

# seen_texts = set()
# batch_data = []

# # Memproses data
# for record in raw_texts:
#     username, original_text = record[15], record[4]
#     if original_text and original_text not in seen_texts:
#         seen_texts.add(original_text)
#         # Membersihkan teks
#         text = user_pattern.sub('', original_text)
#         text = hashtag_pattern.sub('', text)
#         text = url_pattern.sub('', text)
#         text = rt_pattern.sub('', text)
#         text = " ".join(text.split())
#         text = clean(text, no_emoji=True)
#         text = text.translate(str.maketrans('', '', string.punctuation))

#         # Mengganti kata-kata informal
#         words = []
#         for word in text.split():
#             words.append(kamus.get(word, word))
#         text = " ".join(words)

#         # Mengaplikasikan stemming dan penghapusan stopword
#         text = stemmer.stem(text)
#         text = stopword.remove(text)

#         # Menyiapkan data untuk dimasukkan secara batch
#         batch_data.append((username, original_text, text))

# # Memasukkan teks yang telah diproses ke basis data secara batch
# insert_query = "INSERT INTO proses (username, full_text, processed_text) VALUES (%s, %s, %s)"
# cursor.executemany(insert_query, batch_data)
# mydb.commit()

# # Menutup cursor dan koneksi
# cursor.close()
# mydb.close()

# import mysql.connector
# import re
# import string
# from cleantext import clean
# from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
# from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory

# # Fungsi untuk menghapus emoji
# def remove_emoji(text):
#     emoji_pattern = re.compile(
#         "["
#         u"\U0001F600-\U0001F64F"  # emoticons
#         u"\U0001F300-\U0001F5FF"  # symbols & pictographs
#         u"\U0001F680-\U0001F6FF"  # transport & map symbols
#         u"\U0001F700-\U0001F77F"  # alchemical symbols
#         u"\U0001F780-\U0001F7FF"  # Geometric Shapes Extended
#         u"\U0001F800-\U0001F8FF"  # Supplemental Arrows-C
#         u"\U0001F900-\U0001F9FF"  # Supplemental Symbols and Pictographs
#         u"\U0001FA00-\U0001FA6F"  # Chess Symbols
#         u"\U0001FA70-\U0001FAFF"  # Symbols and Pictographs Extended-A
#         u"\U00002702-\U000027B0"  # Dingbats
#         u"\U000024C2-\U0001F251" 
#         "]+", flags=re.UNICODE)
#     return emoji_pattern.sub(r'', text)

# # Menyambungkan ke basis data
# mydb = mysql.connector.connect(
#     host="localhost",
#     user="root",
#     passwd="",
#     database="ta"
# )
# cursor = mydb.cursor()

# # Mengambil semua data sekaligus
# cursor.execute("SELECT DISTINCT * FROM data_raw")
# raw_texts = cursor.fetchall()

# cursor.execute("SELECT * FROM kamus")
# kamus = {row[1]: row[2] for row in cursor.fetchall()}

# # Mempersiapkan pola regex
# user_pattern = re.compile("@[A-Za-z0-9_]+")
# hashtag_pattern = re.compile("#[A-Za-z0-9_]+")
# url_pattern = re.compile(r'http\S+')
# rt_pattern = re.compile("RT : ")

# # Menginisialisasi alat pemrosesan bahasa
# stemmer = StemmerFactory().create_stemmer()
# stopword = StopWordRemoverFactory().create_stop_word_remover()

# seen_texts = set()
# batch_data = []

# # Memproses data
# for record in raw_texts:
#     username, original_text = record[15], record[4]
#     if original_text and original_text not in seen_texts:
#         seen_texts.add(original_text)
#         # Membersihkan teks
#         text = user_pattern.sub('', original_text)
#         text = hashtag_pattern.sub('', text)
#         text = url_pattern.sub('', text)
#         text = rt_pattern.sub('', text)
#         text = " ".join(text.split())
#         text = clean(text)  # Hapus no_emoji karena cleantext tidak mendukung parameter ini
#         text = remove_emoji(text)  # Panggil fungsi remove_emoji untuk menghapus emoji
#         text = text.translate(str.maketrans('', '', string.punctuation))

#         # Mengganti kata-kata informal
#         words = []
#         for word in text.split():
#             words.append(kamus.get(word, word))
#         text = " ".join(words)

#         # Mengaplikasikan stemming dan penghapusan stopword
#         text = stemmer.stem(text)
#         text = stopword.remove(text)

#         # Menyiapkan data untuk dimasukkan secara batch
#         batch_data.append((username, original_text, text))

# # Memasukkan teks yang telah diproses ke basis data secara batch
# insert_query = "INSERT INTO proses (username, full_text, processed_text) VALUES (%s, %s, %s)"
# cursor.executemany(insert_query, batch_data)
# mydb.commit()

# # Menutup cursor dan koneksi
# cursor.close()
# mydb.close()

import mysql.connector
import re
import string
from cleantext import clean
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory

# Fungsi untuk menghapus emoji
def remove_emoji(text):
    emoji_pattern = re.compile(
        "["
        u"\U0001F600-\U0001F64F"  # emoticons
        u"\U0001F300-\U0001F5FF"  # symbols & pictographs
        u"\U0001F680-\U0001F6FF"  # transport & map symbols
        u"\U0001F700-\U0001F77F"  # alchemical symbols
        u"\U0001F780-\U0001F7FF"  # Geometric Shapes Extended
        u"\U0001F800-\U0001F8FF"  # Supplemental Arrows-C
        u"\U0001F900-\U0001F9FF"  # Supplemental Symbols and Pictographs
        u"\U0001FA00-\U0001FA6F"  # Chess Symbols
        u"\U0001FA70-\U0001FAFF"  # Symbols and Pictographs Extended-A
        u"\U00002702-\U000027B0"  # Dingbats
        u"\U000024C2-\U0001F251" 
        "]+", flags=re.UNICODE)
    return emoji_pattern.sub(r'', text)

# Menyambungkan ke basis data
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="ta"
)
cursor = mydb.cursor()

# Mengambil semua data sekaligus
cursor.execute("SELECT DISTINCT * FROM data_raw")
raw_texts = cursor.fetchall()

cursor.execute("SELECT * FROM kamus")
kamus = {row[1]: row[2] for row in cursor.fetchall()}

# Mempersiapkan pola regex
user_pattern = re.compile("@[A-Za-z0-9_]+")
hashtag_pattern = re.compile("#[A-Za-z0-9_]+")
url_pattern = re.compile(r'http\S+')
rt_pattern = re.compile("RT : ")

# Menginisialisasi alat pemrosesan bahasa
stemmer = StemmerFactory().create_stemmer()
stopword = StopWordRemoverFactory().create_stop_word_remover()

seen_texts = set()
batch_data = []

# Memproses data
for record in raw_texts:
    username, original_text = record[15], record[4]
    if original_text and original_text not in seen_texts:
        seen_texts.add(original_text)
        # Membersihkan teks
        text = user_pattern.sub('', original_text)
        text = hashtag_pattern.sub('', text)
        text = url_pattern.sub('', text)
        text = rt_pattern.sub('', text)
        text = " ".join(text.split())
        text = clean(text)  # Hapus no_emoji karena cleantext tidak mendukung parameter ini
        text = remove_emoji(text)  # Panggil fungsi remove_emoji untuk menghapus emoji
        text = text.translate(str.maketrans('', '', string.punctuation))

        # Mengganti kata-kata informal
        words = []
        for word in text.split():
            words.append(kamus.get(word, word))
        text = " ".join(words)

        # Mengaplikasikan stemming dan penghapusan stopword
        text = stemmer.stem(text)
        text = stopword.remove(text)

        # Menyiapkan data untuk dimasukkan secara batch
        batch_data.append((username, original_text, text))

# Memasukkan teks yang telah diproses ke basis data secara batch
insert_query = "INSERT INTO proses (username, full_text, processed_text) VALUES (%s, %s, %s)"
cursor.executemany(insert_query, batch_data)
mydb.commit()

# Menutup cursor dan koneksi
cursor.close()
mydb.close()