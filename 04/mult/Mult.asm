// This file is part of www.nand2tetris.org
// and the book "The Elements of Computing Systems"
// by Nisan and Schocken, MIT Press.
// File name: projects/04/Mult.asm

// Multiplies R0 and R1 and stores the result in R2.
// (R0, R1, R2 refer to RAM[0], RAM[1], and RAM[2], respectively.)

// Put your code here.

// initialize sum to 0
@sum
M=0

// initialize i to 0
@i
M=0

// Read a value

@R0
D=M

@a
M=D

// Read b value

@R1
D=M

@b
M=D

// compare a and b values

@a
D=M-D

@BGREATER
D;JLT

@BLESSOREQUAL
0;JMP

(BGREATER)

@a
D=M

@low
M=D

@b
D=M

@high
M=D

@LOOP
0;JMP

(BLESSOREQUAL)

@b
D=M

@low
M=D

@a
D=M

@high
M=D

@LOOP
0;JMP

(LOOP)

@i
D=M

@low
D=D-M // i - low

@FINALIZE
D;JGE // if iteration greater or equal the lower digit it's time to finish

// if condition met (still in the loop)
// add the higher digit to the sum

@high
D=M

@sum
M=M+D

// increment i

@i
M=M+1

@LOOP
0;JMP

(FINALIZE)

// assign the current sum value to the output pin

@sum
D=M

@R2
M=D

(END)

@END
0;JMP