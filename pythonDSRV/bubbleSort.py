#my attempt at a bubble sort

def bubbleSort(arr):
    length = len(arr)
    
    # check every element in the array
    for i in range(length):
        swapped = False

        for j in range(0, length-i-1):
            # if prev element is greater than next, switch
            if arr[j] > arr[j+1]:
                arr[j], arr[j+1] = arr[j+1], arr[j]
                swapped = True
        if (swapped == False):
            break

def main():
    prices = [36.99, 12.42, 42.00, 53.22, 145, 98.77, 24.4]
    print("unsorted: " + str(prices))
    bubbleSort(prices)
    print("sorted: " + str(prices))

if __name__ == "__main__":
    main()