import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.LineNumberReader;
import java.util.Random;
import java.util.Scanner;
import java.io.File;

// "hangmanProject" - Word Generator
// Written by Raihan Tanvir

// NOTES
// A possible improvement is finding a way to directly call the list from online rather than locally.
// When pulling file, insert code that automatically reads the length and height of the code. (I SOMEHOW CODED THIS)

// warning: I am astonishingly terrible at code

public class hangmanProjectWord {
	
	// This is the local location of the CSV file.
	// The location of the CSV file and the dimensions of Excel sheet will need to be updated manually.

	public static String wordGenerator() {
		
		int tempLength = 0;
		int tempHeight = 0;
		
		// gameWord is initialized and declared as empty so it can still be returned.
		String gameWord = "empty";
		
		String filePath = "/Users/monarch/Desktop/HangmanWordList.csv/";
		
		String line = "";
		
		try {
			
			// Counting integer is opened and initialized.
			int i = 0;
			
			// This reads text from the CSV files that is imported / called.
			BufferedReader csvFileReader = new BufferedReader(new FileReader(filePath));
			
			// A pseudorandom generator is opened.
			Random randomNumber = new Random();
			
			// Length and height of the Excel sheet. (CHANGE THIS LIVE)
			int listLength = getLengthOfCSV(filePath);
			int listHeight = getHeightOfCSV(filePath);
			
			// An array using the Excel sheet height is created.
			String[] verticalValues = new String[listHeight];
			
			while(i < listHeight && (line = csvFileReader.readLine()) != null) {
				
				// This sets the word that is to be used for the game into a proper variable
				String[] horizontalValues = line.split(",");
				
				int randomHorizontal = randomNumber.nextInt(listLength);
				
				// This gives the random number used to count horizontally
				// System.out.println(randomHorizontal);
				
				verticalValues[i] = horizontalValues[randomHorizontal];
				i++;
				
				// This, along with the random variables used, can be used to trace whether the code is properly shifting.
				// System.out.println("TEST: " + verticalValues[i - 1]);
				
			}
		
		int randomVertical = randomNumber.nextInt(listHeight);
			
		// This gives the random number used to count vertically
		//System.out.println(randomVertical);		
		
		gameWord = verticalValues[randomVertical];
		
		// This code tests that word is being properly printed
		// System.out.println("TEST: " + gameWord);
		
		// BufferedReader is no longer needed and is closed.
		csvFileReader.close();
		
		}
		// This catches exceptions.	
		catch (FileNotFoundException e) {
			e.printStackTrace();
		}
		catch (IOException e) {	
			e.printStackTrace();
		}
			
		// The word to be used in the game is returned: method can be called in other classes.
		return gameWord;
		
	}
	
	
	public static int getHeightOfCSV(String x) {
		int foundHeight = 0;
		
		// This should pull the height of the CSV file.
		try 
		(
		   FileReader input = new FileReader(x);
		   LineNumberReader count = new LineNumberReader(input);
		)
		{
		   while (count.skip(Long.MAX_VALUE) > 0) {
		      // Loop is put here just in case the file is longer than long or doesn't complete reading the file.
		   }
		   
		   // The +1 is to account for the fact that the index starts at 0 instead of 1.
		   foundHeight = count.getLineNumber();
		   System.out.println("Expected height is 3, what is pulled is: " + foundHeight);
		
		} 
		catch (IOException e) {
			e.printStackTrace();
		}
		
		return foundHeight;
		//This is the end of the method for pulling the height of the CSV file.	
	}
		
	public static int getLengthOfCSV(String y) {
		// This method follows the same process as getHeightOfCSV except it uses a scanner and reads through a line
		// to find the length
		
		int foundLength = 0;
		
	    File file = new File(y);
	    Scanner scanner;
	    
	    try {
	        scanner = new Scanner(file);
	    } 
	    
	    catch (FileNotFoundException e) {
	        e.printStackTrace();
	        return -1;
	    }

	    if (scanner.hasNextLine()) {
	        foundLength = scanner.nextLine().split(",").length;
	    }
	    
	    scanner.close();
	    
	    System.out.println("Expected length is 17, what is pulled is: " + foundLength);
		return foundLength;
		
		//This is the end of the method for pulling the length of the CSV file.	
	}
		
}
	
	// This main is left here just incase it is needed.
	//public static void main(String[] args) {	
	//}
	

	