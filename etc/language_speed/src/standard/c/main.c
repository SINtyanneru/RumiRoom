#include <stdio.h>
#include <stdint.h>
#include <time.h>

int main(void) {
	struct timespec t0, t1;
	clock_gettime(CLOCK_MONOTONIC, &t0);

	uint64_t a = 0, b = 1;
	for (long i = 0; i < 1000000000L; i++) {
		uint64_t t = a + b;
		a = b;
		b = t;
	}

	clock_gettime(CLOCK_MONOTONIC, &t1);
	double dt = (double)(t1.tv_sec - t0.tv_sec) + (double)(t1.tv_nsec - t0.tv_nsec) / 1000000000.0;
	//printf("結果: %llu\n", (unsigned long long)a);
	printf("C(clang): 時間: %.3f秒\n", dt);
	return 0;
}
