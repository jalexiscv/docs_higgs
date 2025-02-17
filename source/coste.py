import os

def count_characters_in_files(directory):
    total_characters = 0
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith('.rst'):
                with open(os.path.join(root, file), 'r', encoding='utf-8') as f:
                    total_characters += len(f.read())
    return total_characters

input_directory = 'C:/xampp/Code-Higgs-Framework/source'
total_characters = count_characters_in_files(input_directory)
print(f'Total characters: {total_characters}')