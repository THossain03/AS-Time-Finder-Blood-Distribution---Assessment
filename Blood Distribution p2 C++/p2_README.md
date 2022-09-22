Access:
A quick compile on an IDE or a command window run using g++ calls can make this C++ file run.

Problem Info:
This algorithm takes in two lines of 8 number values. For the first line, the user enter the distribution of blood units by type. The second line the user enters the number of patients awaiting to receive blood grouped by their blood type again. The input is detected by the sequence (type O-, type O+, type A-, type A+, type B-, type B+, type AB-, type AB+) in that format for both lines.
The ultimate output determines the maximum number of patients that can viabally receive blood based on their blood type's specific scientific circumstances. 

Design:
I like using vector containers while coding in C++ and decided to also give it a go here to implement my structure and procedures. I mainly used a double for-loop to iterate through the entire vector representing num. of patients, and used the inner for loop to decide which type of blood unit is accessible for the patients of the interested blood type. Used logic to also determine how much of the blood units the patients of that blood type would be able to take. I ran test cases for s4.1 - s4.5, seeing match and successes on the command window for all 5 cases.   

