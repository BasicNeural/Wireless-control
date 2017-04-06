#!/usr/bin/python
import serial
import MySQLdb

ser = serial.Serial("/dev/ttyUSB0", 9600)
ser.flushInput()
db = MySQLdb.connect("localhost", "root", "1234", "db")
cursor = db.cursor()
while 1:
	if(ser.inWaiting() > 0):
		value = ser.readline()
		temp = int(value)
		cursor.execute("INSERT INTO Temp (temp) VALUES (%s)", temp)
		db.commit()
		print (temp)