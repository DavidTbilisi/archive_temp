import mysql.connector 
import pprint
import numpy as np

db = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="archive_db_checker"
)
pp = pprint.PrettyPrinter(indent=4)
d = db.cursor(dictionary=True)
def by_level(level = 1):
  d.execute(f"select * from io_object where level_of_description_id = '{level}'")
  return d.fetchall()



def get_data(parent_id = 1, level=2):
	d.execute(f"""SELECT
	archive_db_checker.io_object.id,
	archive_db_checker.io_object.level_of_description_id,
	archive_db_checker.io_object.parent_id
FROM
	archive_db_checker.io_object
WHERE
	archive_db_checker.io_object.level_of_description_id = {level}
	AND archive_db_checker.io_object.parent_id = {parent_id}""")
	return d.fetchall()

anaweri = get_data(837)
saqme = []
for a in anaweri:
	saqme += get_data(parent_id=a.get('id'), level=3)
pp.pprint(saqme)
print(f"ანაწერი:{len(anaweri)}, სასქმე:{len(saqme)}")
