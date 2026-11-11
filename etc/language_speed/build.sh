#-----------------------------標準-----------------------------

#C
echo "C Standard"
clang src/standard/c/main.c -o bin/standard/c.out

#Rust
echo "Rust Standard"
rustc src/standard/rust/main.rs -o bin/standard/rust.out
chmod +x bin/standard/rust.out

#ObjC
echo "ObjC Standard"
clang -MMD -MP -DGNUSTEP -DGNUSTEP_BASE_LIBRARY=1 -DGNU_RUNTIME=1 -DGNUSTEP_BASE_LIBRARY=1 -fno-strict-aliasing -fexceptions -fobjc-exceptions -D_NATIVE_OBJC_EXCEPTIONS -pthread -fPIC -Wall -DGSWARN -DGSDIAGNOSE -Wno-import -g -fconstant-string-class=NSConstantString -I. -I/home/rumisan/GNUstep/Library/Headers -I/usr/local/include/GNUstep -I/usr/include/x86_64-linux-gnu/GNUstep -I/usr/include $(gnustep-config --base-libs) -I /usr/lib/gcc/x86_64-linux-gnu/14/include/ -o bin/standard/objc.out src/standard/objc/main.m

#-----------------------------標準-----------------------------

#C
echo "C MAX"
clang -O3 src/max/c/main.c -o bin/max/c.out

#Rust
echo "Rust MAX"
export CARGO_TARGET_DIR=$HOME/language_speed_target
cd src/max/rust/
cargo build --release
cp $CARGO_TARGET_DIR/release/rust ../../../bin/max/rust.out
cd ../../../
chmod +x bin/max/rust.out

#ObjC
echo "ObjC MAX"
clang -MMD -MP -DGNUSTEP -DGNUSTEP_BASE_LIBRARY=1 -DGNU_RUNTIME=1 -DGNUSTEP_BASE_LIBRARY=1 -fno-strict-aliasing -fexceptions -fobjc-exceptions -D_NATIVE_OBJC_EXCEPTIONS -pthread -fPIC -Wall -DGSWARN -DGSDIAGNOSE -Wno-import -g -fconstant-string-class=NSConstantString -I. -I/home/rumisan/GNUstep/Library/Headers -I/usr/local/include/GNUstep -I/usr/include/x86_64-linux-gnu/GNUstep -I/usr/include $(gnustep-config --base-libs) -I /usr/lib/gcc/x86_64-linux-gnu/14/include/ -O3 -o bin/max/objc.out src/max/objc/main.m
