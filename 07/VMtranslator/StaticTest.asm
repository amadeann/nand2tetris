// C_PUSH command
// command: C_PUSH, segment: constant, index: 111
@0
D=A
@111
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 333
@0
D=A
@333
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 888
@0
D=A
@888
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: static, index: 8
@SP
M=M-1
A=M
D=M
@R13
M=D
@StaticTest.8
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// C_POP command
// command: C_POP, segment: static, index: 3
@SP
M=M-1
A=M
D=M
@R13
M=D
@StaticTest.3
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// C_POP command
// command: C_POP, segment: static, index: 1
@SP
M=M-1
A=M
D=M
@R13
M=D
@StaticTest.1
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
// C_PUSH command
// command: C_PUSH, segment: static, index: 3
@StaticTest.3
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: static, index: 1
@StaticTest.1
D=M
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
// C_PUSH command
// command: C_PUSH, segment: static, index: 8
@StaticTest.8
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
