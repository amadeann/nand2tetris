// C_PUSH command
// command: C_PUSH, segment: constant, index: 3030
@0
D=A
@3030
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: pointer, index: 0
@SP
M=M-1
A=M
D=M
@R13
M=D
@3
D=A
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
// command: C_PUSH, segment: constant, index: 3040
@0
D=A
@3040
A=D+A
D=A
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
// command: C_PUSH, segment: constant, index: 32
@0
D=A
@32
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: this, index: 2
@SP
M=M-1
A=M
D=M
@R13
M=D
@THIS
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
// command: C_PUSH, segment: constant, index: 46
@0
D=A
@46
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: that, index: 6
@SP
M=M-1
A=M
D=M
@R13
M=D
@THAT
D=M
@6
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
// command: C_PUSH, segment: pointer, index: 0
@3
D=A
@0
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
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
// C_PUSH command
// command: C_PUSH, segment: this, index: 2
@THIS
D=M
@2
A=D+A
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
// command: C_PUSH, segment: that, index: 6
@THAT
D=M
@6
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
