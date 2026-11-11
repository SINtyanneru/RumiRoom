#import <Foundation/Foundation.h>

@interface Fibonacci : NSObject
- (NSInteger)runWithCount:(NSInteger)count;
@end

@implementation Fibonacci
- (NSInteger)runWithCount:(NSInteger)count {
	//高速倍加法：(F(k), F(k+1)) → (F(2k), F(2k+1))、countのビットを上から走査
	NSInteger a = 0;
	NSInteger b = 1;
	for (NSInteger bit = 62; bit >= 0; bit--) {
		NSInteger c = a * (2 * b - a);
		NSInteger d = a * a + b * b;
		if ((count >> bit) & 1) {
			a = d;
			b = c + d;
		} else {
			a = c;
			b = d;
		}
	}
	return a;
}
@end

int main(void) {
	NSAutoreleasePool *pool = [[NSAutoreleasePool alloc] init];

	Fibonacci *fib = [[Fibonacci alloc] init];
	NSDate *start = [NSDate date];
	NSInteger result = [fib runWithCount:1000000000];
	NSTimeInterval dt = [[NSDate date] timeIntervalSinceDate:start];

	NSLog(@"結果: %ld", result);
	NSLog(@"ObjC: 時間: %.0fナノ秒", dt * 1000000000.0);

	[fib release];
	[pool drain];
	return 0;
}
