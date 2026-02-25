import os
import shutil
import json
import uuid
import mysql.connector
return

new_dir = "./Stamp/"
package_dir_path = "./STICKERS/"
package_list = [name for name in os.listdir(package_dir_path)
				if os.path.isdir(os.path.join(package_dir_path, name))]

sql = mysql.connector.connect(
	host="192.168.0.130",
	user="rumi_room",
	password="aqaz12345569apapapa14463229",
	database="rumisan_room"
)

for package in package_list:
	package_path = os.path.join(package_dir_path, package)
	product_info = None
	with open(os.path.join(package_path, "productInfo.meta"), "r") as f:
		product_info = json.load(f)

	cursor = sql.cursor()
	cursor.execute("SELECT `ID` FROM `LINESTAMP_CREATOR` WHERE `NAME` = '"+product_info["author"]["ja"]+"';")
	creator_result = cursor.fetchone()
	creator_id = creator_result[0]
	cursor.close()

	package_id = str(uuid.uuid4())
	package_line_id = product_info["packageId"]
	package_title = product_info["title"]["ja"]
	package_animation = product_info["hasAnimation"]
	package_sound = product_info["hasSound"]
	package_sale = product_info["onSale"]

	cursor = sql.cursor()
	cursor.execute(f"INSERT INTO `LINESTAMP_STAMP` (`ID`, `CREATOR`, `LINE_ID`, `TITLE`, `USE_ANIMATION`, `USE_AUDIO`, `SALE`) VALUES (%s, %s, %s, %s, %s, %s, %s)", (package_id, creator_id, package_line_id, package_title, package_animation, package_sound, package_sale))
	sql.commit()
	cursor.close()

	shutil.copyfile(os.path.join(package_path, "tab_on.png"), os.path.join(new_dir, package_id + "-" + "tab_on.png"))
	shutil.copyfile(os.path.join(package_path, "tab_off.png"), os.path.join(new_dir, package_id + "-" + "tab_off.png"))

	stamp_list = os.listdir(package_path)
	for stamp in stamp_list:
		if (stamp == "productInfo.meta" or stamp == "tab_on.png" or stamp == "tab_off.png" or stamp.endswith("_key.png") or stamp.endswith("_key.gif")):
			continue
		image_id = str(uuid.uuid4())
		image_animation = False

		if (stamp.endswith(".gif")):
			image_animation = True

		shutil.copyfile(os.path.join(package_path, stamp), os.path.join(new_dir, image_id))

		cursor = sql.cursor()
		cursor.execute(f"INSERT INTO `LINESTAMP_IMAGE` (`ID`, `STAMP`, `LINE_ID`, `NAME`, `ANIMATION`) VALUES (%s, %s, %s, %s, %s)", (image_id, package_id, "", stamp, image_animation))
		sql.commit()
		cursor.close()