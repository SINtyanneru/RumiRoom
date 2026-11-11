#import <Foundation/Foundation.h>

@interface Fibonacci : NSObject
- (NSInteger)runWithCount:(NSInteger)count;
@end

@implementation Fibonacci
- (NSInteger)runWithCount:(NSInteger)count {
	NSInteger a = 0;
	NSInteger b = 1;
	for (NSInteger i = 0; i < count; i++) {
		NSInteger t = a + b;
		a = b;
		b = t;
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

	//NSLog(@"結果: %ld", result);
	NSLog(@"ObjC: 時間: %.3f秒", dt);

	[fib release];
	[pool drain];
	return 0;
}
