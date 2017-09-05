// C_PUSH command
// command: C_PUSH, segment: constant, index: 7
@0
D=A
@7
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 8
@0
D=A
@8
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
