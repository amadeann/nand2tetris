// C_PUSH command
// command: C_PUSH, segment: argument, index: 1
@ARG
D=M
@1
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: pointer, index: 1
@SP
M=M-1
A=M
D=M
@R13
M=D
@3
D=A
@1
A=D+A
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// C_PUSH command
// command: C_PUSH, segment: constant, index: 0
@0
D=A
@0
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: that, index: 0
@SP
M=M-1
A=M
D=M
@R13
M=D
@THAT
D=M
@0
A=D+A
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// C_PUSH command
// command: C_PUSH, segment: constant, index: 1
@0
D=A
@1
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: that, index: 1
@SP
M=M-1
A=M
D=M
@R13
M=D
@THAT
D=M
@1
A=D+A
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// C_PUSH command
// command: C_PUSH, segment: argument, index: 0
@ARG
D=M
@0
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 2
@0
D=A
@2
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// sub command
// command: sub
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
M=M-D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: argument, index: 0
@SP
M=M-1
A=M
D=M
@R13
M=D
@ARG
D=M
@0
A=D+A
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// Label
(MAIN_LOOP_START)
// C_PUSH command
// command: C_PUSH, segment: argument, index: 0
@ARG
D=M
@0
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// If statement 
@SP
M=M-1
A=M
D=M
@COMPUTE_ELEMENT
D;JNE
// Goto
@END_PROGRAM
0;JMP
// Label
(COMPUTE_ELEMENT)
// C_PUSH command
// command: C_PUSH, segment: that, index: 0
@THAT
D=M
@0
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: that, index: 1
@THAT
D=M
@1
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// add command
// command: add
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
M=D+M
@SP
M=M+1
// C_POP command
// command: C_POP, segment: that, index: 2
@SP
M=M-1
A=M
D=M
@R13
M=D
@THAT
D=M
@2
A=D+A
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// C_PUSH command
// command: C_PUSH, segment: pointer, index: 1
@3
D=A
@1
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 1
@0
D=A
@1
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// add command
// command: add
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
M=D+M
@SP
M=M+1
// C_POP command
// command: C_POP, segment: pointer, index: 1
@SP
M=M-1
A=M
D=M
@R13
M=D
@3
D=A
@1
A=D+A
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// C_PUSH command
// command: C_PUSH, segment: argument, index: 0
@ARG
D=M
@0
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 1
@0
D=A
@1
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// sub command
// command: sub
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
M=M-D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: argument, index: 0
@SP
M=M-1
A=M
D=M
@R13
M=D
@ARG
D=M
@0
A=D+A
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// Goto
@MAIN_LOOP_START
0;JMP
// Label
(END_PROGRAM)
