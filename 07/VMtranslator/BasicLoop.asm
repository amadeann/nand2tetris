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
// command: C_POP, segment: local, index: 0
@SP
M=M-1
A=M
D=M
@R13
M=D
@LCL
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
(LOOP_START)
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
// command: C_PUSH, segment: local, index: 0
@LCL
D=M
@0
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
// command: C_POP, segment: local, index: 0
@SP
M=M-1
A=M
D=M
@R13
M=D
@LCL
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
// C_POP command
// command: C_POP, segment: , index: 
@SP
M=M-1
A=M
D=M
@LOOP_START
D;JNE
// C_PUSH command
// command: C_PUSH, segment: local, index: 0
@LCL
D=M
@0
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
