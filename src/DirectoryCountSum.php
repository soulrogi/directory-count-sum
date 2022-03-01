<?php

declare(strict_types=1);

namespace soulrogi\directoryCountSum;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class DirectoryCountSum {
	private RecursiveIteratorIterator $directoryIterator;

	/**
	 * @param string $searchPath Путь к директории для поиска.
	 * @param string $fileName   Имя искомого файла.
	 */
	public function __construct(private string $fileName, string $searchPath) {
		$this->directoryIterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($searchPath)
		);
	}

	public function getResult(): int {
		$result = 0;
		foreach ($this->directoryIterator as $item) { /** @var RecursiveDirectoryIterator $item */
			if ($item->isFile() && $this->fileName === $item->getFilename()) {
				$file = $item->openFile();

				while (false === $file->eof()) {
					$result += (int)$file->fgets();
				}
			}
		}

		return $result;
	}
}
