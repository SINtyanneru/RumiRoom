import time

MASK = 18446744073709551615 #2^64-1、uint64の巻き戻し再現用

def fib(n):
	#高速倍加法：(F(k), F(k+1)) → (F(2k), F(2k+1))、nのビットを上から走査
	a = 0
	b = 1
	for bit in range(n.bit_length() - 1, -1, -1):
		c = (a * ((2 * b - a) & MASK)) & MASK
		d = (a * a + b * b) & MASK
		if (n >> bit) & 1:
			a = d
			b = (c + d) & MASK
		else:
			a = c
			b = d
	return a

start = time.perf_counter()
result = fib(1000000000)
dt = time.perf_counter() - start
print("結果:", result)
print("Python(python3): 時間: %dナノ秒" % int(dt * 1000000000))
