// C_PUSH command
// command: C_PUSH, segment: constant, index: 17
@0
D=A
@17
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 17
@0
D=A
@17
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// eq command
// command: eq
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP1
D;JEQ

@SP
A=M
M=0
(StackTest.JMP1)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 17
@0
D=A
@17
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 16
@0
D=A
@16
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// eq command
// command: eq
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP3
D;JEQ

@SP
A=M
M=0
(StackTest.JMP3)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 16
@0
D=A
@16
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 17
@0
D=A
@17
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// eq command
// command: eq
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP5
D;JEQ

@SP
A=M
M=0
(StackTest.JMP5)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 892
@0
D=A
@892
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 891
@0
D=A
@891
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// lt command
// command: lt
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP7
D;JLT

@SP
A=M
M=0
(StackTest.JMP7)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 891
@0
D=A
@891
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 892
@0
D=A
@892
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// lt command
// command: lt
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP9
D;JLT

@SP
A=M
M=0
(StackTest.JMP9)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 891
@0
D=A
@891
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 891
@0
D=A
@891
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// lt command
// command: lt
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP11
D;JLT

@SP
A=M
M=0
(StackTest.JMP11)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 32767
@0
D=A
@32767
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 32766
@0
D=A
@32766
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// gt command
// command: gt
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP13
D;JGT

@SP
A=M
M=0
(StackTest.JMP13)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 32766
@0
D=A
@32766
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 32767
@0
D=A
@32767
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// gt command
// command: gt
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP15
D;JGT

@SP
A=M
M=0
(StackTest.JMP15)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 32766
@0
D=A
@32766
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 32766
@0
D=A
@32766
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// gt command
// command: gt
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
D=M-D
M=-1
@StackTest.JMP17
D;JGT

@SP
A=M
M=0
(StackTest.JMP17)
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 57
@0
D=A
@57
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 31
@0
D=A
@31
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 53
@0
D=A
@53
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
// C_PUSH command
// command: C_PUSH, segment: constant, index: 112
@0
D=A
@112
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
// neg command
// command: neg
@SP
M=M-1
A=M
M=-M
@SP
M=M+1
// and command
// command: and
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
M=D&M
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 82
@0
D=A
@82
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// or command
// command: or
@SP
M=M-1
A=M
D=M
@SP
M=M-1
A=M
M=D|M
@SP
M=M+1
// not command
// command: not
@SP
M=M-1
A=M
M=!M
@SP
M=M+1
