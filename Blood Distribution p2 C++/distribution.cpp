#include <iostream>
#include <vector>
#include <string>
#include <fstream>
#include <sstream>

using namespace std;

int main () {

    cout << "Enter data (number of units for each type first line, number of patients with each blood type in second):" << endl;

    vector <int> num_units;
    vector <int> num_patients;
    
    /* For file reading, uncomment if wanted, but make sure to comment out the getline() functions below for those with a streaming to cin.
    ifstream file;
    file.open("file.txt"); //temporary change to appropriate file name of course.
    string input1;string input2;
    getline(file,input1);
    getline(file,input2);  //... continue after this with the code starting with istringstream i1(input1/input2)...
    */

    // getting line1 specifying number of units for each blood type
    string input1;
    getline(cin, input1);
    istringstream i1(input1);
    int num1;
    while(i1>>num1) num_units.push_back(num1);
    // getting line2 specifying number of units for each blood type
    string input2;
    getline(cin, input2);
    istringstream i2(input2);
    int num2;
    while(i2>>num2) num_patients.push_back(num2);


    int max_blood_distrib = 0;
    // main iterator for the patients by type vector
    vector<int>::iterator patientNum;
    //a 2-d array that will be used to prioritize by order what type of unit each patient type should prefer to use before the other. Each array element in this element is kind of like a priority array that will determine to check which unit to see first is available.
    int prioritylist[8][8] = {/* O- */{0,-1,-1,-1,-1,-1,-1,-1},/* O+ */{1,0,-1,-1,-1,-1,-1,-1},/* A- */{2,0,-1,-1,-1,-1,-1,-1},/* A+ */{3,2,1,0,-1,-1,-1,-1},/* B- */{4,0,-1,-1,-1,-1,-1,-1},/* B+ */{5,4,1,0,-1,-1,-1,-1},/* AB- */{6,4,2,0,-1,-1,-1,-1},/* AB+ */{7,6,5,4,3,2,1,0}};
    int counter = 0;

    //The following will determine the process of assigning more undiversed patients be given units of blood first, followed by more patients with more diverse blood types as we go on.
    for (patientNum = num_patients.begin(); patientNum != num_patients.end(); patientNum++) {
        for (int i=0; i<8; i++) {
            if(prioritylist[counter][i] == (-1)) {
                break;
            }
            int units_left = num_units.at(prioritylist[counter][i]);
            if (units_left > 0 && *patientNum > 0) {
                if (*patientNum >= units_left) { //all units will be used so set to 0, patientNum will be used to the amount of units left.
                    max_blood_distrib += units_left;
                    num_patients.at(counter) = num_patients.at(counter) - units_left;
                    *patientNum = num_patients.at(counter);
                    num_units.at(prioritylist[counter][i]) = 0;
                    units_left = num_units.at(prioritylist[counter][i]);
                } else { //some units will be remain which would be just a deduction of the PatientNum value. Patients will all get their blood, and no shortage will be at hand, so set PatientNum=0.
                    max_blood_distrib += *patientNum;
                    num_units.at(prioritylist[counter][i]) = num_units.at(prioritylist[counter][i]) - (*patientNum);
                    units_left = num_units.at(prioritylist[counter][i]);
                    num_patients.at(counter) = 0;
                    *patientNum = num_patients.at(counter);
                }
            }
        }
        counter++;   
    }

    //Output the calculated maximum possible number of patients that can receive the blood.
    cout << max_blood_distrib << endl;
    
}