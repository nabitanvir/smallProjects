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

        # 
        while i < len(leftHalf) and j < len(rightHalf):
            if leftHalf[i] <= rightHalf[j]:
                array[k] = leftHalf[i]
                i += 1
            else:
                array[k] = rightHalf[j]
                j += 1
            k += 1

        # check for remaining elements
        while i < len(leftHalf):
            array[k] = leftHalf[i]
            i += 1
            k += 1
        
        while j < len(rightHalf):
            array[k] = rightHalf[j]
            j += 1
            k += 1

def main():
    # note: duplicate nums in list
    nums = [60, 20, 5, 50, 30, 70, 43, 59, 2, 1, 52, 75, 52]
    print("list before mergeSort: " + str(nums))
    mergeSort(nums)
    print("list after sort is: " + str(nums))

if __name__ == "__main__":
    main()