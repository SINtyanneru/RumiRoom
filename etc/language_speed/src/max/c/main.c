#include <stdio.h>
#include <stdint.h>
#include <time.h>

int main(void) {
	struct timespec t0, t1;
	clock_gettime(CLOCK_MONOTONIC, &t0);

	//(F(k), F(k+1)) → (F(2k), F(2k+1)) の公式で、nをビット走査しながら一気に進める
	const uint64_t n = 1000000000ULL;
	uint64_t a = 0;
	uint64_t b = 1;
	for (int bit = 30; bit >= 0; bit--) {
		uint64_t c = a * (2 * b - a);
		uint64_t d = a * a + b * b;
		if ((n >> bit) & 1) {
			a = d;
			b = c + d;
		} else {
			a = c;
			b = d;
		}
	}

	clock_gettime(CLOCK_MONOTONIC, &t1);
	long long ns = (long long)(t1.tv_sec - t0.tv_sec) * 1000000000LL + (t1.tv_nsec - t0.tv_nsec);
	printf("結果: %llu\n", (unsigned long long)a);
	printf("C(clang): 時間: %lldナノ秒\n", ns);
	return 0;
}
