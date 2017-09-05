// C_PUSH command
// command: C_PUSH, segment: constant, index: 10
@0
D=A
@10
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
// C_PUSH command
// command: C_PUSH, segment: constant, index: 21
@0
D=A
@21
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 22
@0
D=A
@22
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: argument, index: 2
@SP
M=M-1
A=M
D=M
@R13
M=D
@ARG
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
// C_POP command
// command: C_POP, segment: argument, index: 1
@SP
M=M-1
A=M
D=M
@R13
M=D
@ARG
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
// command: C_PUSH, segment: constant, index: 36
@0
D=A
@36
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: this, index: 6
@SP
M=M-1
A=M
D=M
@R13
M=D
@THIS
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
// command: C_PUSH, segment: constant, index: 42
@0
D=A
@42
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 45
@0
D=A
@45
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: that, index: 5
@SP
M=M-1
A=M
D=M
@R13
M=D
@THAT
D=M
@5
A=D+A
D=A
@R14
M=D
@R13
D=M
@R14
A=M
M=D
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
// command: C_PUSH, segment: constant, index: 510
@0
D=A
@510
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: temp, index: 6
@SP
M=M-1
A=M
D=M
@R13
M=D
@5
D=A
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
// C_PUSH command
// command: C_PUSH, segment: that, index: 5
@THAT
D=M
@5
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
// command: C_PUSH, segment: this, index: 6
@THIS
D=M
@6
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: this, index: 6
@THIS
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
// command: C_PUSH, segment: temp, index: 6
@5
D=A
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
