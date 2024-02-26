# my attempt at implementing a mergeSort

#notes
# divide and conquer algorithm


def mergeSort(array):
    length = len(array)
    # BASE CASE FOR RECURSIVE CALLS CHECK, makes sure if its still divisible
    if length > 1:
        midVal = length // 2
        leftHalf = array[:midVal]
        rightHalf = array[midVal:]

        mergeSort(leftHalf)
        mergeSort(rightHalf)

        #initialize temp values
        i, j, k = 0, 0, 0

        


        


        


def main():
    # note: duplicate nums in list
    nums = [60, 20, 5, 50, 30, 70, 43, 59, 2, 1, 52, 75, 52]
    print("list before mergeSort: " + str(nums))

if __name__ == "__main__":
    main()