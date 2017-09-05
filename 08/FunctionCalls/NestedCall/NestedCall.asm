// Bootstrap code
@256
D=A
@SP
M=D
// Call function Sys.init
// Push the return address
@$ret.0
D=A
@SP
A=M
M=D
@SP
M=M+1
@LCL
D=M
@SP
A=M
M=D
@SP
M=M+1
@ARG
D=M
@SP
A=M
M=D
@SP
M=M+1
@THIS
D=M
@SP
A=M
M=D
@SP
M=M+1
@THAT
D=M
@SP
A=M
M=D
@SP
M=M+1
@5
D=A
@SP
D=M-D
@ARG
M=D
@SP
D=M
@LCL
M=D
// Go to Sys.init
@Sys.init
0;JMP
($ret.0)
// Write function Sys.init
// Current function set to: Sys.init
// Previous function set to: 
(Sys.init)
// C_PUSH command
// command: C_PUSH, segment: constant, index: 4000
@0
D=A
@4000
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
// command: C_PUSH, segment: constant, index: 5000
@0
D=A
@5000
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
// Call function Sys.main
// Push the return address
@Sys.init$ret.1
D=A
@SP
A=M
M=D
@SP
M=M+1
@LCL
D=M
@SP
A=M
M=D
@SP
M=M+1
@ARG
D=M
@SP
A=M
M=D
@SP
M=M+1
@THIS
D=M
@SP
A=M
M=D
@SP
M=M+1
@THAT
D=M
@SP
A=M
M=D
@SP
M=M+1
@5
D=A
@SP
D=M-D
@ARG
M=D
@SP
D=M
@LCL
M=D
// Go to Sys.main
@Sys.main
0;JMP
(Sys.init$ret.1)
// C_POP command
// command: C_POP, segment: temp, index: 1
@SP
M=M-1
A=M
D=M
@R13
M=D
@5
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
// Label
(Sys.init$LOOP)
// Goto
@Sys.init$LOOP
0;JMP
// Write function Sys.main
// Current function set to: Sys.main
// Previous function set to: Sys.init
(Sys.main)
@0
D=A
@SP
A=M
M=D
@SP
M=M+1
@0
D=A
@SP
A=M
M=D
@SP
M=M+1
@0
D=A
@SP
A=M
M=D
@SP
M=M+1
@0
D=A
@SP
A=M
M=D
@SP
M=M+1
@0
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: constant, index: 4001
@0
D=A
@4001
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
// command: C_PUSH, segment: constant, index: 5001
@0
D=A
@5001
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
// command: C_PUSH, segment: constant, index: 200
@0
D=A
@200
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: local, index: 1
@SP
M=M-1
A=M
D=M
@R13
M=D
@LCL
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
// command: C_PUSH, segment: constant, index: 40
@0
D=A
@40
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: local, index: 2
@SP
M=M-1
A=M
D=M
@R13
M=D
@LCL
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
// command: C_PUSH, segment: constant, index: 6
@0
D=A
@6
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// C_POP command
// command: C_POP, segment: local, index: 3
@SP
M=M-1
A=M
D=M
@R13
M=D
@LCL
D=M
@3
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
// command: C_PUSH, segment: constant, index: 123
@0
D=A
@123
A=D+A
D=A
@SP
A=M
M=D
@SP
M=M+1
// Call function Sys.add12
// Push the return address
@Sys.main$ret.2
D=A
@SP
A=M
M=D
@SP
M=M+1
@LCL
D=M
@SP
A=M
M=D
@SP
M=M+1
@ARG
D=M
@SP
A=M
M=D
@SP
M=M+1
@THIS
D=M
@SP
A=M
M=D
@SP
M=M+1
@THAT
D=M
@SP
A=M
M=D
@SP
M=M+1
@6
D=A
@SP
D=M-D
@ARG
M=D
@SP
D=M
@LCL
M=D
// Go to Sys.add12
@Sys.add12
0;JMP
(Sys.main$ret.2)
// C_POP command
// command: C_POP, segment: temp, index: 0
@SP
M=M-1
A=M
D=M
@R13
M=D
@5
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
// command: C_PUSH, segment: local, index: 1
@LCL
D=M
@1
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: local, index: 2
@LCL
D=M
@2
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: local, index: 3
@LCL
D=M
@3
A=D+A
D=M
@SP
A=M
M=D
@SP
M=M+1
// C_PUSH command
// command: C_PUSH, segment: local, index: 4
@LCL
D=M
@4
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
// Return from Sys.main
@LCL
D=M
@R13
M=D
@5
D=A
@R13
D=M-D
A=D
D=M
@R14
M=D
@SP
A=M-1
D=M
@ARG
A=M
M=D
@ARG
D=M+1
@SP
M=D
@1
D=A
@R13
D=M-D
A=D
D=M
@THAT
M=D
@2
D=A
@R13
D=M-D
A=D
D=M
@THIS
M=D
@3
D=A
@R13
D=M-D
A=D
D=M
@ARG
M=D
@4
D=A
@R13
D=M-D
A=D
D=M
@LCL
M=D
@R14
A=M
0;JMP
// Write function Sys.add12
// Current function set to: Sys.add12
// Previous function set to: Sys.main
(Sys.add12)
// C_PUSH command
// command: C_PUSH, segment: constant, index: 4002
@0
D=A
@4002
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
// command: C_PUSH, segment: constant, index: 5002
@0
D=A
@5002
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
// command: C_PUSH, segment: constant, index: 12
@0
D=A
@12
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
// Return from Sys.add12
@LCL
D=M
@R13
M=D
@5
D=A
@R13
D=M-D
A=D
D=M
@R14
M=D
@SP
A=M-1
D=M
@ARG
A=M
M=D
@ARG
D=M+1
@SP
M=D
@1
D=A
@R13
D=M-D
A=D
D=M
@THAT
M=D
@2
D=A
@R13
D=M-D
A=D
D=M
@THIS
M=D
@3
D=A
@R13
D=M-D
A=D
D=M
@ARG
M=D
@4
D=A
@R13
D=M-D
A=D
D=M
@LCL
M=D
@R14
A=M
0;JMP
