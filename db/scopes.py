import mysql.connector 
import pprint


db = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="archive_normalized_scopes"
)
pp = pprint.PrettyPrinter(indent=4)
d = db.cursor(dictionary=True)


d.execute("select DISTINCT(creator) from scope3")
creators = d.fetchall()

d.execute("select DISTINCT(fond) from scope3")
fonds = d.fetchall()

d.execute("select DISTINCT(anaweri) from scope3")
anaweri = d.fetchall()

d.execute("select DISTINCT(saqme) from scope3")
sasqme = d.fetchall()



# print( len(creators) )
# print( len(fonds) )
# print( len(anaweri) )
# print( len(sasqme) )






# REPORT GENERATOR
# for creator in creators:
# 	for fond in fonds:
# 		for anawer in anaweri:
# 			for saqme in sasqme:
# 				sql = f"""
# 				select count(faili) as file_count 
# 				from scope3 
# 				where creator = '{creator.get('creator')}' 
# 				AND fond = '{fond.get('fond')}' 
# 				AND anaweri = '{anawer.get('anaweri')}' 
# 				AND saqme = '{saqme.get('saqme')}'
# 				"""
# 				print(sql, end="-")
# 				d.execute(sql)
# 				fc = d.fetchone()
# 				print(fc.get("file_count"))
# 				f = open('report_q.log', 'a')
# 				f.write(f"{creator.get('creator')}_{fond.get('fond')}_{anawer.get('anaweri')}_{saqme.get('saqme')}_{fc.get('file_count')}\n")
# 				f.close()


