use std::time::Instant;

fn main() {
	let start = Instant::now();

	let mut a: u64 = 0;
	let mut b: u64 = 1;
	for _ in 0..1000000000 {
		let t = a.wrapping_add(b);
		a = b;
		b = t;
	}

	let dt = start.elapsed();
	//println!("結果: {}", a);
	println!("Rust(rustc): 時間: {:.3}秒", dt.as_secs_f64());
}
