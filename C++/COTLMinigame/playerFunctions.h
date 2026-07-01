#include <iostream>
#include <vector>

using namespace std;

struct Player{
    int PlayerScore = 0;
    vector<vector<int>> PlayerPlacements = {
        {1,2,3},
        {4,5,6},
        {7,8,9}
    };

    void PlayerScoreCount(vector<vector<int>>& PlayerPlacements){

    }

    void RollAndPlace(vector<vector<int>>& PlayerPlacements){
        int randomNum;
        int column;
        int row;

        cout << "Number: ";
        cin >> randomNum;
        cout << endl;

        cout << "Column: "; 
        cin >> column;
        cout << endl << "Row: ";
        cin >> row;

    }
};
