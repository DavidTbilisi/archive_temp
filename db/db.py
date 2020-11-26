import mysql.connector 
# import pandas as pd
from matplotlib import pyplot as plt

db = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="archive_db_checker"
)

d = db.cursor(dictionary=True)
def by_level(level = 1):
  d.execute(f"select * from io_object where level_of_description_id = '{level}'",)
  return d.fetchall()




x = []
for row in by_level(2):
  print()
  x.append(row["id"])
  # print("\n")
plt.plot(x)
plt.title("io_object - IDs")
plt.show()