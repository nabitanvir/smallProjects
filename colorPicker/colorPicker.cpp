#include <iostream>
#include <cstdlib>
#include <ctime> 
#include <string>
#include <limits> 

class ColorPicker {
private:
    std::string colors[7];

public:
    void setElement(int index, std::string color) {
        if (index >= 0 && index < 7) {
            colors[index] = color;
        }
    }

    void printColors() {
        for (int i = 0; i < 7; i++) {
            std::cout << colors[i] << " ";
        }
        std::cout << std::endl;
    }

    void pickRandomColor() {
        int index = rand() % 7;
        std::cout << "Random color: " << colors[index] << std::endl;
    }
};

int main() {
    srand(static_cast<unsigned int>(time(0)));

    ColorPicker myColorPicker;
    myColorPicker.setElement(0, "red");
    myColorPicker.setElement(1, "orange");
    myColorPicker.setElement(2, "yellow");
    myColorPicker.setElement(3, "green");
    myColorPicker.setElement(4, "blue");
    myColorPicker.setElement(5, "indigo");
    myColorPicker.setElement(6, "violet");

    std::cout << "Press enter to print random color or Ctrl+C to exit" << std::endl;

    while (true) {
        std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
        myColorPicker.printColors();
        myColorPicker.pickRandomColor();
    }

    return 0;
}
