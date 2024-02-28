import random

global drink
drink = "i drink too much celsius"

def stripMaster():
    print("stripMaster test:")
    testStr = "   wow   "
    print(testStr)
    print(testStr.strip() + "\n")

def sliceMaster(string):
    print("sliceMaster test:")
    string.strip()
    print(string[17:] + "\n")

def stringPrint(string):
    print("stringPrint test")
    #if statement is case sensitive
    if "celsius" in string:
        print("Yeah you do drink too much celsius")
    if "water" not in string:
        print("Also you do not drink enough water\n")

def addMaster(int1, int2, int3):
    print("addMaster test:")
    final = 0
    final += (int1 + int2 + int3)
    print("final number: " + str(final) + "\n")

def placeholderMaster():
    print("placeholderMaster test:")
    food1 = "Popeyes"
    food2 = "Canes"
    food3 = "KFC"
    myOpinion = "I think that {} is better than {} however on \"dark\" days I like {}"
    print(myOpinion.format(food1, food2, food3) + "\n")

def booleanMaster(x, y):
    print("booleanMaster test:")
    # Any string is True, except empty strings.
    # Any number is True, except 0.
    if (x == y):
        print (str(x) + " is equal to " + str(y) + "\n")
    elif (x >= y):
        print(str(x) + " is greater than or equal to " + str(y) + "\n")
    elif(x <= y):
        print(str(x) + " is less than or equal to " + str(y) + "\n")

def listTest():
    print("listTest test:")
    testList = ["orange", "banana", "apple"]
    print("list: " + str(testList))
    print("length of list: " + str(len(testList)))
    if "apple" in testList:
        print("Apple is in this list")
    # insert in list
    testList.insert(3, "guava")
    print("new list after insert: " + str(testList))
    testList.append("mango")
    print("new list after append: " + str(testList))
    [print(x) for x in testList]
    
    print("forloop list test")
    for x in testList:
        if "m" in x:
            print(x)
    #newline
    print("")

def lengthTesting():
    print("lengthTesting test:")
    array = [1, 2, 3, 4, 5]
    length = len(array)
    print(length)
    print("")

def main():
    #ask for user input


    x, y, z = random.randrange(1, 10), random.randrange(1, 10), random.randrange(1, 10)
    print("before sum: " + str(x) + " " + str(y) + " " + str(z) + "\n")
    addMaster(x, y, z)
    stringPrint(drink)
    sliceMaster(drink)
    stripMaster()
    placeholderMaster()
    booleanMaster(x, y)
    listTest()
    lengthTesting()
    

if __name__ == "__main__":
    main()


# notes
# List is a collection which is ordered and changeable. Allows duplicate members.
# Tuple is a collection which is ordered and unchangeable. Allows duplicate members.
# Set is a collection which is unordered, unchangeable*, and unindexed. No duplicate members.
# Dictionary is a collection which is ordered** and changeable. No duplicate members.