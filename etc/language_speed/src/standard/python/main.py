import time

start = time.perf_counter()

MASK = 18446744073709551615 #2^64-1、uint64の巻き戻し再現用
a = 0
b = 1
for i in range(1000000000):
	a, b = b, (a + b) & MASK

dt = time.perf_counter() - start
#print("結果:", a)
print("Python(python3): 時間: %.3f秒" % dt)
