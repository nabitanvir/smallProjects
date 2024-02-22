#include <iostream>
#include <vector>
#include <string>
#include <fstream>
#include <random>
#include <stdexcept>
#include <algorithm>
#include <chrono>
#include <thread>
#include <iomanip>
#include <curses.h>

using namespace std;

string chooseTheme() {
    string theme;
    cout << "Memory Matching Game Menu" << endl;
    cout << endl;
    cout << "Choose Theme (Enter 1, 2, or 3): " << endl;
    cout << "1. Flower Species" << endl;
    cout << "2. Jellyfish Species" << endl;
    cout << "3. Manga Series" << endl;
    cout << endl;
    int themeNumber = 0;
    cin >> themeNumber;
    system("clear");
    // adjust file paths as needed
    if (themeNumber == 1) {
        theme = ".";
    } else if (themeNumber == 2) {
        theme = ".";
    } else {
        theme = ".";
    }
    return theme;
}

int chooseGrid() {
    int size = 0;
    cout << "Select size of playing grid (Enter A, B, or C):" << endl;
    cout << "A. 4x4 Grid (SMALL)" << endl;
    cout << "B. 6x6 Grid (MEDIUM)" << endl;
    cout << "C. 8x8 Grid (LARGE)" << endl;
    cout << endl;
    char gridSize;
    cin >> gridSize;
    system("clear");
    if (gridSize == 'A' || gridSize == 'a') {
        size = 4;
    } else if (gridSize == 'B' || gridSize == 'b') {
        size = 6;
    } else {
        size = 8;
    }
    return size;
}

int chooseTime() {
    int time = 0;
    cout << "Select time word pair on screen (Enter F, M, or S)" << endl;
    cout << "F. 2 Seconds (FAST)" << endl;
    cout << "M. 4 Seconds (MODERATE)" << endl;
    cout << "S. 6 Seconds (SLOW)" << endl;
    cout << endl;
    char wordTime;
    cin >> wordTime;
    system("clear");
    if (wordTime == 'F' || wordTime == 'f') {
        time = 2;
    } else if (wordTime == 'M' || wordTime == 'm') {
        time = 4;
    } else {
        time = 6;
    }
    return time;
}

void initializeGrid(vector<vector<string> >& grid, int size) {
    grid.resize(size, vector<string>(size, "X"));
}

void printGrid(const vector<vector<string> >& grid) {
    for (const auto& row : grid) {
        for (const auto& cell : row) {
            cout << setw(10) << left << cell;
        }
        cout << endl;
    }
}

void gameGrid(const string& filepath, int size, vector<vector<string> >& answerGrid) {
    int numPairs = (size * size) / 2;
    ifstream file(filepath);
    if (!file.is_open()) {
        throw runtime_error("Unable to open file: " + filepath);
    }

    vector<string> words;
    string word;
    while (words.size() < numPairs && file >> word) {
        words.push_back(word);
    }
    file.close();

    if (words.size() < numPairs) {
        throw runtime_error("Not enough words in the file to fill the grid.");
    }

    vector<string> gridWords;
    for (const auto& w : words) {
        gridWords.push_back(w);
        gridWords.push_back(w);
    }

    random_device rd;
    mt19937 g(rd());
    shuffle(gridWords.begin(), gridWords.end(), g);

    answerGrid.resize(size, vector<string>(size));
    auto wordIter = gridWords.begin();
    for (int i = 0; i < size; ++i) {
        for (int j = 0; j < size; ++j) {
            answerGrid[i][j] = *wordIter++;
        }
    }
}

void flipCard(vector<vector<string> >& visibleGrid, const vector<vector<string> >& answerGrid, int row, int col) {
    visibleGrid[row][col] = answerGrid[row][col];
}

bool isGameWon(const vector<vector<string> >& visibleGrid, const vector<vector<string> >& answerGrid) {
    return visibleGrid == answerGrid;
}

void playGame(vector<vector<string> >& visibleGrid, const vector<vector<string> >& answerGrid, int time) {
    cout << "Hidden Grid:" << endl;
    printGrid(answerGrid);
    this_thread::sleep_for(chrono::seconds(time));
    system("clear");

    while (!isGameWon(visibleGrid, answerGrid)) {
        int row1, col1, row2, col2;
        cout << "Enter row and column to flip the first card (e.g., 1 2): ";
        cin >> row1 >> col1;
        cout << "Enter row and column to flip the second card (e.g., 1 3): ";
        cin >> row2 >> col2;

        row1--; col1--; row2--; col2--;

        flipCard(visibleGrid, answerGrid, row1, col1);
        printGrid(visibleGrid);

        flipCard(visibleGrid, answerGrid, row2, col2);
        printGrid(visibleGrid);

        if (answerGrid[row1][col1] != answerGrid[row2][col2]) {
            cout << "Not a match. Try again." << endl;
            this_thread::sleep_for(chrono::seconds(time));
            visibleGrid[row1][col1] = "X";
            visibleGrid[row2][col2] = "X";
        } else {
            cout << "Match found!" << endl;
        }

        printGrid(visibleGrid);
    }

    cout << "You win" << endl;
}

int main() {
    string theme = chooseTheme();
    int size = chooseGrid();
    int time = chooseTime();
    cout << "Theme: " << theme << ", Size: " << size << "x" << size << ", Time: " << time << " seconds" << endl;

    vector<vector<string> > visibleGrid, answerGrid;
    initializeGrid(visibleGrid, size);
    gameGrid(theme, size, answerGrid);
    playGame(visibleGrid, answerGrid, time);
    return 0;
}