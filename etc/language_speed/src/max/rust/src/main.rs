use std::time::Instant;

fn main() {
	let start = Instant::now();

	//高速倍加法：(F(k), F(k+1)) → (F(2k), F(2k+1))、C版と同じ手
	let n: u64 = 1000000000;
	let mut a: u64 = 0;
	let mut b: u64 = 1;
	for bit in (0..31).rev() {
		let c = a.wrapping_mul(b.wrapping_mul(2).wrapping_sub(a));
		let d = a.wrapping_mul(a).wrapping_add(b.wrapping_mul(b));
		if (n >> bit) & 1 == 1 {
			a = d;
			b = c.wrapping_add(d);
		} else {
			a = c;
			b = d;
		}
	}

	let dt = start.elapsed();
	println!("結果: {}", a);
	println!("Rust(rustc): 時間: {}ナノ秒", dt.as_nanos());
}
