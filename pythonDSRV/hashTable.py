#my attempt at a hash table in python

class Node:
    def __init__(self, key, value):
        self.key = key
        self.value = value
        self.next = None

class hashTable:
    def __init__(self, capacity):
        self.capacity = capacity
        self.size = 0
        self.table = [None] * capacity

        