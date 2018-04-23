<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/10/17
 * Time: 11:20 AM
 */
echo "<pre>";
// In order to convert decimal to binary we need to first check what power of two will get the number or more than number. Suppose that power is N so the binary number will be N digits long. Then we take 2 ^ N-1 N-2 N-3 ...
// 13 = 1101. Here 2 ^ 4 = 16 > 13 > 2 ^ 3 = 8 so we take 2 ^ 4 so N becomes 4 so now we will have binary number with 4 digits.  2 ^ 3 -> 2 ^ 2 -> 2 ^ 1 -> 2 ^ 0 which means 8 4 2 1 that's why 1 1 0 1.
// From binary to octal can be done by
/**
 * The octal numeral system, or oct for short, is the base-8 number system, and uses the digits 0 to 7. Octal numerals can be made from binary numerals by grouping consecutive binary digits into groups of three (starting from the right). For example, the binary representation for decimal 74 is 1001010. Two zeroes can be added at the left: (00)1 001 010, corresponding the octal digits 1 1 2, yielding the octal representation 112.
 * Hexadecimal representation is base 16 that mean 2 ^ 4 sam way octal is base 8 which means 2 ^ 3 and binary is base 2 which mean 2 ^ 1 and hence we have a group of 4 binary digits(nibble) in hexadecimal 3 binary digits in octal and 1 binary digit in binary.
 * Hexadecimal takes values from 0-9 and then a b c d e f 10 (1+0) and 11 (1+1). Total of 15 digits.
 * In order to convert binary to hexadecimal we make a group of 4 bit from right and then translate it according to the values it takes.
 * So 1101 0101 1100 1111 gets convert to D5CF.
 */
echo addcslashes("zoo['.']", 'a..z')."\n";
echo " \n A..Z \n";
echo addcslashes("zoo['.']", 'A..Z')."\n";
// Also, if the first character in a range has a higher ASCII value than the second character in the range, no range will be constructed. Only the start, end and period characters will be escaped.
echo " \n z..a \n";
echo addcslashes("zoo['.']", 'z..a')."\n";
echo " \n=============== Add Slashes ============\n";
// Cannot define which characters to be escaped it has a defined set of characters (', ", \, null) which are automatically escaped if found in string
echo "\n ".addslashes($testStr)." \n";

echo " \n=============== ORD ============\n";
// returns the ascii value of the given character or string
echo ord($testStr)."\n";
echo ord("]")." //] \n";
echo ord("z")." //z \n";
echo ord("A")." //A \n";
echo ord("a")." //a \n";
echo ord(".")." //. \n";
echo " \n=============== CHR ============\n";
// returns the character value of the given ascii code
echo chr(120)."\n";

echo " \n=============== Bin2Hex ============\n";
// converts binary to hex
echo bin2hex("12345")."\n";
echo bin2hex("kushagra")."\n";
echo bin2hex(12345)."\n";

echo " \n=============== Hex2Bin ============\n";
// returns the character value of the given ascii code.Decodes a hexadecimally encoded binary string and not just convert the base. Returns actual string rather than just 0s and 1s.
echo bin2hex("example hex data")."\n";
echo hex2bin("6578616d706c65206865782064617461")."\n";

echo " \n=============== PACK ============\n";
//Pack data into binary string. Final goal is to return data in binary format or string. The first arguments tell php about what type of data we are trying to
echo pack("nvc*", 0x1234, 0x5678, 65, 66)."\n";
echo pack("aec*", 0x1234, 0x5678, 65, 66)."\n";
echo pack("H*", 0x1234, 0x5678, 65, 66)."\n";
echo pack("H*", "6b75736861677261")."\n";
echo pack("h*", "6b75736861677261")."\n";

echo "\n ======== UNPACK ======== \n";
echo "WITH H \n";
$hex = unpack("H*", "kushagra");
$hex1 = unpack("h*", "kushagra"); // reverses storage order or hexadecimal bytes . For example: 6b75736861677261 get changed to b657378616762716 with pair of 4 bits ( 8 bits making a nibble ) getting swapped in their position so 6b becomes b6 and so on.
$hex2 = bin2hex("kushagra");
print_r($hex);
print_r($hex1);
print_r($hex2);
echo "\n=============== LOW NIBBLE FIRST ================= \n";
echo hex2bin($hex1[1]);
echo "\nWITH a\n";
print_r(unpack("a*", "kushagra"));
echo "WITH A\n";
print_r(unpack("A*", "kushagra"));
echo "WITH S\n";
$s = unpack("S*", "kushagra");
print_r($s);
$s = unpack("H*", "kushagra");
print_r($s);


$ord = ord("kushagra");
echo "\n".$ord;

echo "\n Base Convert \n";
/*
 * In order to convert string to binary manually we need to get ascii character code for every letter then encode it to binary using base 64
 * so that 'k' with ascii value as 107 is represented by 11010110 and hence in hex it is 6b by moving last or least significant bit to first place making it 01101011.
 */
echo "\n".base_convert($hex[1], 16, 2)."\n"; // returns 0s and 1s
echo "\n".hex2bin($hex[1])."\n"; // returns the actual decoded string
echo "\n".base_convert($s[1], 16, 2)."\n";
echo "\n".base_convert($s[2], 16, 2)."\n";
echo "\n".base_convert($s[3], 16, 2)."\n";
echo "\n".base_convert($s[4], 16, 2)."\n";
echo "\n".base_convert($s[4], 8, 2)."\n";
echo "\n".base_convert("1001", 2, 16)."\n";
echo "\n".base_convert("1101", 2, 16)."\n";

echo hex2bin("c6eae6c0b2bee4b2");
echo chr(13);

echo "\n Chop|Rtrim \n";
echo "BEFORE PADDING \n";
$testStr = "This is my name";
echo strlen($testStr);
$strPadded = str_pad($testStr, 55, "^", STR_PAD_BOTH);
echo "\n AFTER PADDING \n ";
echo $strPadded;
echo "\n";
echo strlen($strPadded);
/**
 * string str_pad ( string $input , int $pad_length [, string $pad_string = " " [, int $pad_type = STR_PAD_RIGHT ]] )
This function returns the input string padded on the left, the right, or both sides to the specified padding length. If the optional argument pad_string is not supplied, the input is padded with spaces, otherwise it is padded with characters from pad_string up to the limit.
 */
echo "\n === TRIMMING === \n";
// all type of trims ltrim, rtrim, trim can use character map which will limit the characters to be escaped, also we can give a range of values by using '..' and without the second argument i.e character map it will strip all the characters given below
/*
 " " (ASCII 32 (0x20)), an ordinary space.
"\t" (ASCII 9 (0x09)), a tab.
"\n" (ASCII 10 (0x0A)), a new line (line feed).
"\r" (ASCII 13 (0x0D)), a carriage return.
"\0" (ASCII 0 (0x00)), the NUL-byte.
"\x0B" (ASCII 11 (0x0B)), a vertical tab.
Default value of $character_mask = " \t\n\r\0\x0B"
 */
$strPadded.="\n";
echo trim($strPadded);
echo "\n";
echo rtrim($strPadded);
echo "\n";
echo ltrim($strPadded);
echo "\n";
$trimmed = trim($strPadded, "\n\t\r"); // this will leave spaces untouched. Strip whitespace (or other characters) from the beginning and end of a string

echo $trimmed;
echo "\n";
echo strlen($trimmed);
echo "\n";
echo "============== REMOVING NEW LINES ================= \n";
echo "------ TRIM ------ \n";
echo trim("This is a new string for me \t########", "\n\t\r");
echo "\n";
echo trim("This is a new string for me again \n\n########", "\n");
echo "\n";
echo "------- RTRIM ------- \n";
$rtrim = "This is a new string for me again.\n Again this is a new line. Thisisisisis \n \n \n \n";
echo $rtrim;
echo "\n\n";
echo rtrim($rtrim, " \n\t\ra..zA..Z");
echo "\n ------ LTRIM ------- \n";
$ltrim = "\n This is a new string for me again \n\n########";
echo $ltrim;
echo "\n";
echo ltrim($ltrim, "\n\t\r");

/**
 * str_replace matches for exact occurrence of the string while preg_replace or preg_match will take in a regular expression and will match all the values matching that expression.
 * str_replace replaces a specific occurrence of a string, for instance "foo" will only match and replace that: "foo" in complete string in all places. preg_replace will do regular expression matching, for instance "/f.{2}/" will match and replace "foo", but also "fey", "fir", "fox", "f12", etc.
 * str_ireplace is case insensitive form of str_replace
 */
$trimmed = str_replace(" ", "#", $trimmed);
echo str_replace("Foo", "Bar", "Foo this is another Foo");
echo "\n".$trimmed."\n";
$strPadded = str_replace(" ", "#", $strPadded);
echo "\n".$strPadded."\n";

echo "\n ===== Chunk Split ===== \n";
// The second parameter tells that till what length do we need to split so 2 tell we need to split string after every two characters. Third argument tells what needs to be in the end of every chunk so with '.' and string as 'String'  we would get St.ri.ng.
$chunk_split = "Create a string to split into chunks. But only till the given limit.";
// string chunk_split ( string $body [, int $chunklen = 76 [, string $end = "\r\n" ]] )
echo chunk_split($testStr, 2, "\t\n");
echo chunk_split($testStr, 2, "\t");
echo chunk_split($testStr, 2, "\t");
echo "\n ----- New split string ------- \n";
echo chunk_split($chunk_split, 2);
echo chunk_split($chunk_split, 2, '.');

echo "\n ====== BASE 64 ENCODE======= \n ";
/*
 * When you have some binary data that you want to ship across a network, you generally don't do it by just streaming the bits and bytes over the wire in a raw format. Why? because some media are made for streaming text. You never know -- some protocols may interpret your binary data as control characters (like a modem), or your binary data could be screwed up because the underlying protocol might think that you've entered a special character combination (like how FTP translates line endings).

So to get around this, people encode the binary data into characters. Base64 is one of these types of encodings.

Why 64?
Because you can generally rely on the same 64 characters being present in many character sets, and you can be reasonably confident that your data's going to end up on the other side of the wire uncorrupted.
For some generally used character sets such as english we can directly transfer that data feeling confident that it will be transferred without corruption but for other such as chinese character set , etc. we cannot be sure that exact same information will be received and hence we use base 64 or uuencode algorithms so that we encode that set of character on one end and then decode them at the other
 */
echo $encodedStr = base64_encode($testStr);
echo "\n";
echo ord('u');

echo "\n ==== BASE 64 DECODe ==== \n";
echo base64_decode($encodedStr);

echo "\n ==== UU ENCODE ==== \n";
/*
 * A uuencoded file starts with a header line of the form:

 begin <mode> <file><newline>

Each data line uses the format:

 <length character><formatted characters><newline>
 */
echo "\n VARIABLE\n";
echo convert_uuencode($testStr);
echo "\n DIRECT STRING \n";
$kushagra = "Kushagra";
//echo convert_uuencode($kushagra);
echo "\n FILE \n";
//echo convert_uuencode(file_get_contents("op.txt"));

/**
 * Steps of Base64 and uuencode
 *  Base 64
Base64 encoding takes the original binary data and operates on it by dividing it into tokens of three bytes. A byte consists of eight bits, so Base64 takes 24bits in total. These 3 bytes are then converted into four printable characters from the ASCII standard.

The first step is to take the three bytes (24bit) of binary data and split it into four numbers of six bits. Because the ASCII standard defines the use of seven bits, Base64 only uses 6 bits (corresponding to 2^6 = 64 characters) to ensure the encoded data is printable and none of the special characters available in ASCII are used. The algorithm's name Base64 comes from the use of these 64 ASCII characters. The ASCII characters used for Base64 are the numbers 0-9, the alphabets 26 lowercase and 26 uppercase characters plus two extra characters '+' and '/'.
 *
 * Base64 Encoding/Decoding Table
A	B	C	D	E	F	G	H	I	J	K	L	M	N	O	P
0	1	2	3	4	5	6	7	8	9	10	11	12	13	14	15

Q	R	S	T	U	V	W	X	Y	Z	a	b	c	d	e	f
16	17	18	19	20	21	22	23	24	25	26	27	28	29	30	31

g	h	i	j	k	l	m	n	o	p	q	r	s	t	u	v
32	33	34	35	36	37	38	39	40	41	42	43	44	45	46	47

w	x	y	z	0	1	2	3	4	5	6	7	8	9	+	/
48	49	50	51	52	53	54	55	56	57	58	59	60	61	62	63
 *
 * In our programs, we can simply define this table as a character array. For example in 'C' we will do:

/* ---- Base64 Encoding/Decoding Table ---
char b64[] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
Technically, there is a 65th character '=' in use, but more about it further down.

The ASCII conversion of 3-byte, 24-bit groups is repeated until the whole sequence of original data bytes is encoded. To ensure the encoded data can be properly printed and does not exceed any mail server's line length limit, newline characters are inserted to keep line lengths below 76 characters.

What happens when the last sequence of data bytes to encode is not exactly 3 bytes long? If the size of the original data in bytes is not a multiple of three, we might end up with only one or two remaining (8-bit) bytes. The solution is to add the missing bytes by using a byte value of '0' to create the final 3-byte group. Because these artificial trailing '0's cannot be encoded using the encoding table, we introduce a 65th character: '=' to represent '0'. Naturally, this character can only appear at the end of encoded data.
 * Let's say we want to convert three bytes 155, 162 and 233. The corresponding 24-bit stream is 100110111010001011101001.

155 -> 10011011
162 -> 10100010
233 -> 11101001
Splitting up these bits into 4 groups of 6bit creates the following 4 decimal values: 38, 58, 11 and 41.

100110 -> 38
111010 -> 58
001011 -> 11
101001 -> 41
Converting these into ASCII characters using the Base64 encoding table translates them into the ASCII sequence "m6Lp".
In base 64 normal ascii values dont work ascii values are taken from BASE 64 encoding/decoding table and not from normal encoding/decoding table
38 -> m
58 -> 6
11 -> L
41 -> p
 * So base64 ensure that none of the ascii values are of special characters so that they will not mean anything else by any of the systems the data goes through
 *
 * UUEncode
 * Divide the input bytes stream into blocks of 3 bytes.
Divide the 24 bits of a 3-byte block into 4 groups of 6 bits.
Expand each group of 6 bits to 8 bits and add 32, \x20, so the resulting bit map is representing an ASCII printable character.
If the last 3-byte block has only 1 byte of input data, pad 2 bytes of 1 (\x0101).
If the last 3-byte block has only 2 bytes of input data, pad 1 byte of 1 (\x01).
 * So in uuencode we build a system in which we try to match the generated value to the actual global ascii set not as in case of base 64 which has its own ascii set
 *
 * The main point to note is that bas64 uses 0 to pad if the number of bits are not a multiple of 3 or the last set of 6 bits is not complete   where as uuencode uses 1 to pad .
 *  In base 64 = is used to represent 0 which maybe a padded number also if total number of bits fail to be a multiple of 3.
 */

echo "\n ===== UUDECODE=====  \n";
echo convert_uudecode(convert_uuencode(file_get_contents("op.txt")));

echo "\n ====== Count Chars ===== \n";
// modes in count_chars
/*
 * 0 - an array with the byte-value as key and the frequency of every byte as value.
1 - same as 0 but only byte-values with a frequency greater than zero are listed.
2 - same as 0 but only byte-values with a frequency equal to zero are listed.
3 - a string containing all unique characters is returned.
4 - a string containing all not used characters is return
Array of all the ascii values is returned and not only of the letters used in string for 0,1,2 modes
 */
print_r(count_chars("Two Ts and one F.", 0));
print_r(count_chars("Two Ts and one F.", 1));
print_r(count_chars("Two Ts and one F.", 2));
print_r(count_chars("Two Ts and one F.", 3));
print_r(count_chars("Two Ts and one F.", 4));

echo "\n Crypt \n";
/*
 * CRYPT_STD_DES - Standard DES-based hash with a two character salt from the alphabet "./0-9A-Za-z". Using invalid characters in the salt will cause crypt() to fail.
 * CRYPT_EXT_DES - Extended DES-based hash. The "salt" is a 9-character string consisting of an underscore followed by 4 bytes of iteration count and 4 bytes of salt. These are encoded as printable characters, 6 bits per character, least significant character first. The values 0 to 63 are encoded as "./0-9A-Za-z". Using invalid characters in the salt will cause crypt() to fail.
 * CRYPT_MD5 - MD5 hashing with a twelve character salt starting with $1$
 * CRYPT_BLOWFISH - 33 character long.Blowfish hashing with a salt as follows: "$2a$", "$2x$" or "$2y$", a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z". Using characters outside of this range in the salt will cause crypt() to return a zero-length string. The two digit cost parameter is the base-2 logarithm of the iteration count for the underlying Blowfish-based hashing algorithmeter and must be in range 04-31, values outside this range will cause crypt() to fail. Versions of PHP before 5.3.7 only support "$2a$" as the salt prefix: PHP 5.3.7 introduced the new prefixes to fix a security weakness in the Blowfish implementation. Please refer to » this document for full details of the security fix, but to summarise, developers targeting only PHP 5.3.7 and later should use "$2y$" in preference to "$2a$".
 * CRYPT_SHA256 - SHA-256 hash with a sixteen character salt prefixed with $5$. If the salt string starts with 'rounds=<N>$', the numeric value of N is used to indicate how many times the hashing loop should be executed, much like the cost parameter on Blowfish. The default number of rounds is 5000, there is a minimum of 1000 and a maximum of 999,999,999. Any selection of N outside this range will be truncated to the nearest limit.
 * CRYPT_SHA512 - SHA-512 hash with a sixteen character salt prefixed with $6$. If the salt string starts with 'rounds=<N>$', the numeric value of N is used to indicate how many times the hashing loop should be executed, much like the cost parameter on Blowfish. The default number of rounds is 5000, there is a minimum of 1000 and a maximum of 999,999,999. Any selection of N outside this range will be truncated to the nearest limit.
 * The printable form of these hashes starts with $2$, $2a$, $2b$, $2x$ or $2y$ depending on which variant of the algorithm is used.
 *  If salt is passed then that salt will be used otherwise an automatically generated salt will be used which in case of crypt is a weak salt and will generate a notice. Hence password_hash() is recommended to generate a hash for passwords.
 * password_hash() uses a strong hash, generates a strong salt, and applies proper rounds automatically. password_hash() is a simple crypt() wrapper and compatible with existing password hashes. Use of password_hash() is encouraged.
 * Based on the salt the crypting algorithm is chosen
*/
echo "\n ======= CRYPTS AVAILABLE ==========";
echo "\nCRYPT_STD_DES\n";
echo CRYPT_STD_DES;

echo "\nCRYPT_EXT_DES\n";
echo CRYPT_EXT_DES;

echo "\nCRYPT_MD5\n";
echo CRYPT_MD5;

echo "\nCRYPT_MD5\n";
echo CRYPT_MD5;

echo "\nCRYPT_BLOWFISH\n";
echo CRYPT_BLOWFISH;

echo "\nCRYPT_SHA256\n";
echo CRYPT_SHA256;

echo "\nCRYPT_SHA512\n";
echo CRYPT_SHA512;

echo "\n";
$password = 'mypassword';

// Get the hash, letting the salt be automatically generated
$hash = crypt($password, 'sdflksdlfksdlk');
echo $hash;
echo "\n";
if (CRYPT_STD_DES == 1) {
    echo 'Standard DES: ' . crypt('rasmuslerdorf', 'rl') . "\n";
}
echo "\n";
if (CRYPT_EXT_DES == 1) {
    echo 'Extended DES: ' . crypt('rasmuslerdorf', '_J9..rasm') . "\n";
}
echo "\n";
if (CRYPT_MD5 == 1) {
    echo 'MD5:          ' . crypt('rasmuslerdorf', '$1$rasmusle$') . "\n";
}
echo "\n";
if (CRYPT_BLOWFISH == 1) {
    echo 'Blowfish:     ' . crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$') . "\n";
}
echo "\n";
if (CRYPT_SHA256 == 1) {
    echo 'SHA-256:      ' . crypt('rasmuslerdorf', '$5$rounds=5000$usesomesillystringforsalt$') . "\n";
}
echo "\n";
if (CRYPT_SHA512 == 1) {
    echo 'SHA-512:      ' . crypt('rasmuslerdorf', '$6$rounds=5000$usesomesillystringforsalt$') . "\n";
}
echo "\n";
echo "MD5 using md5(): ".md5("rasmuslerdorf");
echo "\n";
echo "MD5 using hash(): ".hash("md5","rasmuslerdorf");

echo "\n ========= PASSWORD HASH ========= \n";
// Password hash creates a new password hash using one way encryption algorithm.
// Password hash is a wrapper around crypt and hence both can be used with each other . Hash generated from crypt can be used as a salt in password hash.
/**
 * The following algorithms are currently supported:

PASSWORD_DEFAULT - Use the bcrypt algorithm (default as of PHP 5.5.0). Note that this constant is designed to change over time as new and stronger algorithms are added to PHP. For that reason, the length of the result from using this identifier can change over time. Therefore, it is recommended to store the result in a database column that can expand beyond 60 characters (255 characters would be a good choice).
PASSWORD_BCRYPT - Use the CRYPT_BLOWFISH algorithm to create the hash. This will produce a standard crypt() compatible hash using the "$2y$" identifier. The result will always be a 60 character string, or FALSE on failure.
PASSWORD_ARGON2I - Use the Argon2 hashing algorithm to create the hash.
 */
echo password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
echo "\n";
echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, array('salt'=>'$2a$12$usesomesillystringforsalt$', 'cost' => 12));
echo "\n";
echo password_hash("rasmuslerdorf", PASSWORD_DEFAULT, array('salt'=>'$2a$12$usesomesillystringforsalt$', 'cost' => 12));
echo "\n";
echo password_hash("rasmuslerdorf", PASSWORD_DEFAULT, array('salt'=>crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$'), 'cost' => 12));

echo "\n ============= PASSWORD VERIFY ============ \n";
/*
 * Password verify works on the fact that hashes generated by crypt or password_hash have details of salt, cost and algorithm within themselves so no separate mechanism for storing salt is required. Hence password_verify can know all the details directly from the hash supplied.
 * password_verify always works with the hashes generated by password_hash or crypt
 * password_verify — Verifies that a password matches a hash
 */
var_dump(password_verify('rasmuslerdorf', crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$')));
var_dump(password_verify('rasmuslerdorf', password_hash("rasmuslerdorf", PASSWORD_DEFAULT, array('salt'=>crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$'), 'cost' => 12))));
var_dump(password_verify("rasmuslerdorf", md5("rasmuslerdorf"))); //  this will not match because password generated by crypt and password_hash all contain information about salt, cost and algorithm but md5 and hash generate hashes without that.

echo "\n ============== PASSWORD INFO ================ \n";
// Generates info regarding provided hash like which algo is used and its cost. This does not work with crypt and only works with password_hash
var_dump(password_get_info(password_hash("rasmuslerdorf", PASSWORD_DEFAULT, array('salt'=>crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$'), 'cost' => 12))));
var_dump(password_get_info(crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$')));
var_dump(password_get_info(crypt('rasmuslerdorf', '$1$rasmusle$')));

echo "\n ========= Password Needs Rehash ============= \n";
// password_needs_rehash($hash, algo, $options)
// hash generate by password_hash, algo is password algorithm constant which is used in password_hash, $options is the options that we use with password_hash.
// It will check if the hash given can be generated by the algo and the options given.
// Check to see if the supplied hash matches the given options and algorithm. If it doesnot matches the given options then password needs to be rehashed manually again.
var_dump(password_needs_rehash(
    password_hash("rasmuslerdorf", PASSWORD_DEFAULT, array('salt'=>crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$'), 'cost' => 12)), PASSWORD_BCRYPT, array('salt'=>crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$'), 'cost' => 12)));

var_dump(password_needs_rehash(crypt('rasmuslerdorf', '$1$rasmusle$'), PASSWORD_BCRYPT, array('salt'=>crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$'), 'cost' => 12)));

$multipleLinesText = <<<EOF
This is a line
This is another line
This is another line
EOF;


/** FEISTEL CIPHER is a symmetric structure used in the construction of block ciphers
 * Let {\displaystyle {\rm {F}}} {\rm F} be the round function and let {\displaystyle K_{0},K_{1},\ldots ,K_{n}} K_0,K_1,\ldots,K_{n} be the sub-keys for the rounds {\displaystyle 0,1,\ldots ,n} 0,1,\ldots,n respectively.

Then the basic operation is as follows:

Split the plaintext block into two equal pieces, ( {\displaystyle L_{0}} L_{0}, {\displaystyle R_{0}} R_{0})

For each round {\displaystyle i=0,1,\dots ,n} i =0,1,\dots,n, compute

{\displaystyle L_{i+1}=R_{i}\,} L_{i+1} = R_i\,
{\displaystyle R_{i+1}=L_{i}\oplus {\rm {F}}(R_{i},K_{i}).} {\displaystyle R_{i+1}=L_{i}\oplus {\rm {F}}(R_{i},K_{i}).}
Then the ciphertext is {\displaystyle (R_{n+1},L_{n+1})} (R_{n+1}, L_{n+1}).

Decryption of a ciphertext {\displaystyle (R_{n+1},L_{n+1})} (R_{n+1}, L_{n+1}) is accomplished by computing for {\displaystyle i=n,n-1,\ldots ,0} i=n,n-1,\ldots,0

{\displaystyle R_{i}=L_{i+1}\,} R_{i} = L_{i+1}\,
{\displaystyle L_{i}=R_{i+1}\oplus \operatorname {F} (L_{i+1},K_{i}).} {\displaystyle L_{i}=R_{i+1}\oplus \operatorname {F} (L_{i+1},K_{i}).}
Then {\displaystyle (L_{0},R_{0})} (L_0,R_0) is the plaintext again.

One advantage of the Feistel model compared to a substitution–permutation network is that the round function {\displaystyle \operatorname {F} } \operatorname {F} does not have to be invertible.

The diagram illustrates both encryption and decryption. Note the reversal of the subkey order for decryption; this is the only difference between encryption and decryption.
 */

/**
 * In cryptography, an S-box (substitution-box) is a basic component of symmetric key algorithms which performs substitution. In block ciphers, they are typically used to obscure the relationship between the key and the ciphertext — Shannon's property of confusion.

In general, an S-box takes some number of input bits, m, and transforms them into some number of output bits, n, where n is not necessarily equal to m.[1] An m×n S-box can be implemented as a lookup table with 2m words of n bits each. Fixed tables are normally used, as in the Data Encryption Standard (DES), but in some ciphers the tables are generated dynamically from the key (e.g. the Blowfish and the Twofish encryption algorithms).

One good example of a fixed table is the S-box from DES (S5), mapping 6-bit input into a 4-bit output:

S5	Middle 4 bits of input
    0000	0001	0010	0011	0100	0101	0110	0111	1000	1001	1010	1011	1100	1101	1110	1111
00	0010	1100	0100	0001	0111	1010	1011	0110	1000	0101	0011	1111	1101	0000	1110	1001
01	1110	1011	0010	1100	0100	0111	1101	0001	0101	0000	1111	1010	0011	1001	1000	0110
10	0100	0010	0001	1011	1010	1101	0111	1000	1111	1001	1100	0101	0110	0011	0000	1110
11	1011	1000	1100	0111	0001	1110	0010	1101	0110	1111	0000	1001	1010	0100	0101	0011
Given a 6-bit input, the 4-bit output is found by selecting the row using the outer two bits (the first and last bits), and the column using the inner four bits. For example, an input "011011" has outer bits "01" and inner bits "1101"; the corresponding output would be "1001".[2]
Symmetric ciphers use symmetric algorithms to encrypt and decrypt data. These ciphers are used in symmetric key cryptography. A symmetric algorithm uses the same key to encrypt data as it does to decrypt data. For example, a symmetric algorithm will use key  to encrypt some plaintext information like a password into a ciphertext. Then, it uses again to take that ciphertext and turn it back into the password.
 */

/*
 * Blowfish is a keyed, symmetric cryptographic block cipher designed by Bruce Schneier in 1993 and placed in the public domain.  Blowfish is included in a large number of cipher suites and encryption products, including SplashID.  Blowfish’s security has been extensively tested and proven.  As a public domain cipher, Blowfish has been subject to a significant amount of cryptanalysis, and full Blowfish encryption has never been broken.  Blowfish is also one of the fastest block ciphers in public use, making it ideal for a product like SplashID that functions on a wide variety of processors found in mobile phones as well as in notebook and desktop computers.

Schneier designed Blowfish as a general-purpose algorithm, intended as a replacement for the aging DES and free of the problems associated with other algorithms.

Notable features of the design include key-dependent S-boxes and a highly complex key schedule.

How it works: the Blowfish algorithm
Blowfish has a 64-bit block size and a key length of anywhere from 32 bits to 448 bits. It is a 16-round Feistel cipher and uses large key-dependent S-boxes. It is similar in structure to CAST-128, which uses fixed S-boxes.

The diagram to the left shows the action of Blowfish. Each line represents 32 bits. The algorithm keeps two subkey arrays: the 18-entry P-array and four 256-entry S-boxes. The S-boxes accept 8-bit input and produce 32-bit output. One entry of the P-array is used every round, and after the final round, each half of the data block is XORed with one of the two remaining unused P-entries.

The diagram to the right shows Blowfish's F-function. The function splits the 32-bit input into four eight-bit quarters, and uses the quarters as input to the S-boxes. The outputs are added modulo 232 and XORed to produce the final 32-bit output.

Since Blowfish is a Feistel network, it can be inverted simply by XORing P17 and P18 to the ciphertext block, then using the P-entries in reverse order.

The Feistel structure of Blowfish
The Feistel structure of Blowfish
Blowfish's key schedule starts by initializing the P-array and S-boxes with values derived from the hexadecimal digits of pi, which contain no obvious pattern. The secret key is then XORed with the P-entries in order (cycling the key if necessary). A 64-bit all-zero block is then encrypted with the algorithm as it stands. The resultant ciphertext replaces P1 and P2. The ciphertext is then encrypted again with the new subkeys, and P3 and P4 are replaced by the new ciphertext. This continues, replacing the entire P-array and all the S-box entries. In all, the Blowfish encryption algorithm will run 521 times to generate all the subkeys - about 4KB of data is processed.

Blowfish in practice
Blowfish is one of the fastest block ciphers in widespread use, except when changing keys. Each new key requires pre-processing equivalent to encrypting about 4 kilobytes of text, which is very slow compared to other block ciphers. This prevents its use in certain applications, but is not a problem in others, such as SplashID.

Blowfish is not subject to any patents and is therefore freely available for anyone to use. This has contributed to its popularity in cryptographic software.
 */

/**
 * Every round r consists of 4 actions: First, XOR the left half (L) of the data with the r th P-array entry, second, use the XORed data as input for Blowfish's F-function, third, XOR the F-function's output with the right half (R) of the data, and last, swap L and R.

The F-function splits the 32-bit input into four eight-bit quarters, and uses the quarters as input to the S-boxes. The S-boxes accept 8-bit input and produce 32-bit output. The outputs are added modulo 232 and XORed to produce the final 32-bit output (see image in the upper right corner).[3]

After the 16th round, undo the last swap, and XOR L with K18 and R with K17 (output whitening).

Decryption is exactly the same as encryption, except that P1, P2, …, P18 are used in the reverse order. This is not so obvious because xor is commutative and associative. A common misconception is to use inverse order of encryption as decryption algorithm (i.e. first XORing P17 and P18 to the ciphertext block, then using the P-entries in reverse order).
 */
/**
 * The bcrypt function is the default password hash algorithm for OpenBSD[2] and other systems including some Linux distributions such as SUSE Linux.[3] The prefix "$2a$" or "$2b$" (or "$2y$") in a hash string in a shadow password file indicates that hash string is a bcrypt hash in modular crypt format.[4] The rest of the hash string includes the cost parameter, a 128-bit salt (base-64 encoded as 22 characters), and 184 bits of the resulting hash value (base-64 encoded as 31 characters).[5] The cost parameter specifies a key expansion iteration count as a power of two, which is an input to the crypt algorithm.

For example, the shadow password record $2a$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy specifies a cost parameter of 10, indicating 210 key expansion rounds. The salt is N9qo8uLOickgx2ZMRZoMye and the resulting hash is IjZAgcfl7p92ldGxad68LJZdL17lhWy. Per standard practice, the user's password itself is not stored.
 */
/**
 * bcrypt https://www.usenix.org/legacy/publications/library/proceedings/usenix99/full_papers/provos/provos_html/node4.html#fig:eksblowfish
 */

echo "\n ======== FPRINTF ======== \n";
if (!($fp = fopen('php://output', 'w'))) {
    return;
}
$year = strftime("%Y", time());
echo $year;
echo "\n";
$month = strftime("%m", time());
echo $month;
echo "\n";

$day = strftime("%d", time());
echo $day;
echo "\n";

fprintf($fp, "%04d-%02d-%02d", $year, $month, $day);
echo "\n";
$str = "65";
fprintf($fp,  "%c string.", $str);
echo "\n";
$str = "65";
fprintf($fp,  "%o string.", $str);
/*
 * The format string is composed of zero or more directives: ordinary characters (excluding %) that are copied directly to the result and conversion specifications, each of which results in fetching its own parameter. This applies to both sprintf() and printf().

Each conversion specification consists of a percent sign (%), followed by one or more of these elements, in order:

An optional sign specifier that forces a sign (- or +) to be used on a number. By default, only the - sign is used on a number if it's negative. This specifier forces positive numbers to have the + sign attached as well.
An optional padding specifier that says what character will be used for padding the results to the right string size. This may be a space character or a 0 (zero character). The default is to pad with spaces. An alternate padding character can be specified by prefixing it with a single quote ('). See the examples below.
An optional alignment specifier that says if the result should be left-justified or right-justified. The default is right-justified; a - character here will make it left-justified.
An optional number, a width specifier that says how many characters (minimum) this conversion should result in.
An optional precision specifier in the form of a period (.) followed by an optional decimal digit string that says how many decimal digits should be displayed for floating-point numbers. When using this specifier on a string, it acts as a cutoff point, setting a maximum character limit to the string. Additionally, the character to use when padding a number may optionally be specified between the period and the digit.
A type specifier that says what type the argument data should be treated as. Possible types:

% - a literal percent character. No argument is required.
b - the argument is treated as an integer and presented as a binary number.
c - the argument is treated as an integer and presented as the character with that ASCII value.
d - the argument is treated as an integer and presented as a (signed) decimal number.
e - the argument is treated as scientific notation (e.g. 1.2e+2). The precision specifier stands for the number of digits after the decimal point since PHP 5.2.1. In earlier versions, it was taken as number of significant digits (one less).
E - like %e but uses uppercase letter (e.g. 1.2E+2).
f - the argument is treated as a float and presented as a floating-point number (locale aware).
F - the argument is treated as a float and presented as a floating-point number (non-locale aware). Available since PHP 5.0.3.
g - shorter of %e and %f.
G - shorter of %E and %f.
o - the argument is treated as an integer and presented as an octal number.
s - the argument is treated as and presented as a string.
u - the argument is treated as an integer and presented as an unsigned decimal number.
x - the argument is treated as an integer and presented as a hexadecimal number (with lowercase letters).
X - the argument is treated as an integer and presented as a hexadecimal number (with uppercase letters).
 */

// fprintf, sprintf and printf are different by the fact that fprintf can take stream as input and write to that stream, whereas sprintf will return back the formatted string so that it can be stored and printf can only print the formatted string to php://output that is will echo the formatted string which will not be storable.

echo "\n ============= sscanf ================= \n";
 // takes input string as a parameter and parses it based on the format argument as a regular expression and returns it back
// getting the serial number
list($serial) = sscanf("SN/2350001", "SN/%d");
// and the date of manufacturing
$mandate = "January 01 2000";
list($month, $day, $year) = sscanf($mandate, "%s %d %d");
echo "Item $serial was manufactured on: $year-" . substr($month, 0, 3) . "-$day\n";

//The function fscanf() is similar to sscanf(), but it takes its input from a file associated with handle and interprets the input according to the specified format, which is described in the documentation for sprintf().
// vsprintf Operates as sprintf() but accepts an array of arguments, rather than a variable number of arguments.
// vprintf  Operates as printf() but accepts an array of arguments, rather than a variable number of arguments.

echo "\n Number Format \n";
// Format a number with grouped thousands
/*
 * This function accepts either one, two, or four parameters (not three):

If only one parameter is given, number will be formatted without decimals, but with a comma (",") between every group of thousands.

If two parameters are given, number will be formatted with decimals decimals with a dot (".") in front, and a comma (",") between every group of thousands.

If all four parameters are given, number will be formatted with decimals decimals, dec_point instead of a dot (".") before the decimals and thousands_sep instead of a comma (",") between every group of thousands.
string number_format ( float $number [, int $decimals = 0 ] )
string number_format ( float $number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = "," )
Dec Point tells how many integers will be there after decimal point if its greater than from original string then additional 0s are added to the end of the string. If its less than the actual integers in string after decimal point then digits after decimal point are rounded off to specified length.
 */
$number = 1234644767.56;

// english notation (default)
echo number_format($number);
echo "\n";
echo number_format($number, "2");
echo "\n";
echo number_format($number, "3", ".", ",");
echo "\n";
echo number_format($number, "1", ".", ",");
echo "\n";
echo number_format($number, "3", "$$", "###");
echo "\n";
echo number_format(number_format($number), "3"); // generates a notice Notice:  A non well formed numeric value encountered and the returns 1.000 type of string for 1,234
echo "\n";
echo "========== Get Html translation table =========== \n";
/*
ENT_COMPAT	Table will contain entities for double-quotes, but not for single-quotes.
ENT_QUOTES	Table will contain entities for both double and single quotes.
ENT_NOQUOTES	Table will neither contain entities for single quotes nor for double quotes.
ENT_HTML401	Table for HTML 4.01.
ENT_XML1	Table for XML 1.
ENT_XHTML	Table for XHTML.
ENT_HTML5	Table for HTML 5.
array get_html_translation_table ([ int $table = HTML_SPECIALCHARS [, int $flags = ENT_COMPAT | ENT_HTML401 [, string $encoding = "UTF-8" ]]] )
 */
echo "Default ===== \n";
print_r(get_html_translation_table()); // default returns HTML_SPECIALCHARS table . We can specify Which table to return. Either HTML_ENTITIES or HTML_SPECIALCHARS.
echo "HTML_SPECIALCHARS ===== \n";
print_r(get_html_translation_table(HTML_SPECIALCHARS));
echo "HTML_ENTITIES ===== \n";
print_r(get_html_translation_table(HTML_ENTITIES));
echo "ENT_HTML5 ===== \n";
print_r(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | ENT_HTML5));
echo "ENT_QUOTES | ENT_HTML5 ===== \n";
print_r(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | ENT_HTML5));

echo "HTML_SPECIALCHARS ===== \n";
// returns different representations in browser and cli
echo "ENT_HTML5 ===== \n";
print_r(get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES | ENT_HTML5));
echo "ENT_QUOTES | ENT_HTML5 ===== \n";
print_r(get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES | ENT_HTML5));

echo "\n===== htmlspecialchars ===== \n";
/*
 * ENT_COMPAT	Will convert double-quotes and leave single-quotes alone.
ENT_QUOTES	Will convert both double and single quotes.
ENT_NOQUOTES	Will leave both double and single quotes unconverted.
ENT_IGNORE	Silently discard invalid code unit sequences instead of returning an empty string. Using this flag is discouraged as it » may have security implications.
ENT_SUBSTITUTE	Replace invalid code unit sequences with a Unicode Replacement Character U+FFFD (UTF-8) or &#xFFFD; (otherwise) instead of returning an empty string.
ENT_DISALLOWED	Replace invalid code points for the given document type with a Unicode Replacement Character U+FFFD (UTF-8) or &#xFFFD; (otherwise) instead of leaving them as is. This may be useful, for instance, to ensure the well-formedness of XML documents with embedded external content.
ENT_HTML401	Handle code as HTML 4.01.
ENT_XML1	Handle code as XML 1.
ENT_XHTML	Handle code as XHTML.
ENT_HTML5	Handle code as HTML 5.
 */
// convert special characters such as < to their encoded format (&lt;) which have individual specific meaning in html
$new = htmlspecialchars("<a href='test'>Test</a>");// &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;
echo $new;

echo "\n ====== Htmlentities ===== \n";
$str = "A 'quote' is <b>bold</b>";

// Outputs: A 'quote' is &lt;b&gt;bold&lt;/b&gt;
echo htmlentities($str);
echo "\n";
// Outputs: A &#039;quote&#039; is &lt;b&gt;bold&lt;/b&gt;
echo htmlentities($str);
echo "\n";
$str = "\x8F!!!";

// Outputs an empty string
echo htmlentities($str, ENT_QUOTES, "UTF-8"); // without ignore invalid string returns empty
echo "\n";
// Outputs "!!!"
echo htmlentities($str, ENT_QUOTES | ENT_IGNORE, "UTF-8"); // with ignore invalid string is skipped silently
echo "\n";

echo " ============ Html special chars vs Html special entities =============== \n";
echo htmlspecialchars("&amp;");
echo "\n";
echo htmlentities("<a href='test'>Test</a>");
echo "\n";
echo htmlentities("<a href='test'>Test</a>", ENT_QUOTES);
echo "\n";
echo htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
echo "\n";
echo "\n ============= Html special characters decode ================ \n";
/*
 * ENT_COMPAT	Will convert double-quotes and leave single-quotes alone.
ENT_QUOTES	Will convert both double and single quotes.
ENT_NOQUOTES	Will leave both double and single quotes unconverted.
ENT_HTML401	Handle code as HTML 4.01.
ENT_XML1	Handle code as XML 1.
ENT_XHTML	Handle code as XHTML.
ENT_HTML5	Handle code as HTML 5.
 */
$orig = "I'll \"walk\" the <b>dog</b> now";

echo " ----- using htmlentites ------ \n";
$a = htmlentities($orig);

$b = html_entity_decode($a);

echo $a; // I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now
echo "\n";
echo $b; // I'll "walk" the <b>dog</b> now

echo " \n ----- using htmlspecialchars ------\n ";
$a = htmlspecialchars($orig);

$b = html_entity_decode($a);

echo $a; // I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now
echo "\n";
echo $b; // I'll "walk" the <b>dog</b> now
// htmlspecialchars changes only 5 entities with special characters if we want all special entities which have special characters meaning then we use htmlentities()
echo "\n htmlspecialchars_decode \n";

$str = "<p>this -&gt; &quot;</p>\n";

echo htmlspecialchars_decode($str);

// note that here the quotes aren't converted
echo htmlspecialchars_decode($str, ENT_NOQUOTES);

$orig = "I'll \"walk\" the <b>dog</b> now";

$a = htmlentities($orig);

$b = html_entity_decode($a);

echo $a; // I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now

echo $b; // I'll "walk" the <b>dog</b> now
/*
 * ENT_COMPAT	Will convert double-quotes and leave single-quotes alone.
ENT_QUOTES	Will convert both double and single quotes.
ENT_NOQUOTES	Will leave both double and single quotes unconverted.
ENT_HTML401	Handle code as HTML 4.01.
ENT_XML1	Handle code as XML 1.
ENT_XHTML	Handle code as XHTML.
ENT_HTML5	Handle code as HTML 5.
 */
$str = "<p>this -&gt; &quot;</p>\n";

echo htmlspecialchars_decode($str);
echo "\n";
// note that here the quotes aren't converted
echo htmlspecialchars_decode($str, ENT_NOQUOTES);

echo "\n ============= levenshtein ============== \n";
// can be used to calculate distance between two strings and suggest the correct or nearest string
// int levenshtein ( string $str1 , string $str2 )
//int levenshtein ( string $str1 , string $str2 , int $cost_ins , int $cost_rep , int $cost_del )
//The Levenshtein distance is defined as the minimal number of characters you have to replace, insert or delete to transform str1 into str2. This function returns the Levenshtein-Distance between the two argument strings or -1, if one of the argument strings is longer than the limit of 255 characters.
$input = 'carrrot';

// array of words to check against
$words  = array('apple','pineapple','banana','orange',
    'radish','carrot','pea','bean','potato');
// no shortest distance found, yet
$shortest = -1;

// loop through words to find the closest
foreach ($words as $word) {

    // calculate the distance between the input word,
    // and the current word
    $lev = levenshtein($input, $word);

    // check for an exact match
    if ($lev == 0) {

        // closest word is this one (exact match)
        $closest = $word;
        $shortest = 0;

        // break out of the loop; we've found an exact match
        break;
    }

    // if this distance is less than the next found shortest
    // distance, OR if a next shortest word has not yet been found
    if ($lev <= $shortest || $shortest < 0) {
        // set the closest match, and shortest distance
        $closest  = $word;
        $shortest = $lev;
    }
}

echo "Input word: $input\n";
if ($shortest == 0) {
    echo "Exact match found: $closest\n";
} else {
    echo "Did you mean: $closest?\n";
}

echo "\n ======= Similar Text ============ \n";
// takes in 3 arguments first two are string to compare and third is optional percentage argument which tells to return the similarity in percentage
$var_1 = 'PHP IS GREAT';
$var_2 = 'WITH MYSQL';

similar_text($var_1, $var_2, $percent);

echo $percent;
// 27.272727272727
echo "\n";
similar_text("carrot", "carrrot", $percent);

echo $percent;
echo "\n";
// 18.181818181818

echo " ========= LOCALE CONV ========= \n";
setlocale(LC_ALL, 'en_GB');
$locale_info = localeconv();
print_r($locale_info);

echo "\n =========== MD5 File ============ \n";
echo md5_file("op.txt");
echo "\n";
echo md5_file("op.txt", true); //When TRUE, returns the digest in raw binary format with a length of 16.
echo "\n";

echo "\n =========== SHA1 File ============ \n";
echo sha1_file("op.txt");
echo "\n";
echo sha1_file("op.txt", true); //When TRUE, returns the digest in raw binary format with a length of 16.
echo "\n";
echo strlen("f32c37e64ec45d6ae1bea3e12fbf3488");
echo "\n";
echo strlen("c45e6762c25e79e629fc84a58a932633b5962136");
echo "\n";

echo "\n =========== MD5 ============ \n";
echo md5("kushagra");
echo "\n";

echo "\n =========== SHA1 ============ \n";
echo sha1("kushagra");
echo "\n";

echo "\n ====== Date Time ====== \n";
// Can be treated as the amalgamation of strftime, strtotime, date and other date time related functionalities

$datetime = new DateTime(); // if we dont pass anything then it returns current date time object
$datetimeToday = new DateTime("today");
$datetimeNow = new DateTime("now");
$yesterday = new DateTime('yesterday');
$twoDaysLater = new DateTime('+ 2 days');
$oneWeekEarly = new DateTime('- 1 week');
print_r($datetime);
print_r($datetimeToday);
print_r($datetimeNow);
print_r($yesterday);
print_r($twoDaysLater);
print_r($oneWeekEarly);
echo "\n ------- Change Date Time Zone -------- \n";
// For changing Date Time Zone we can we need to use DateTimeZone object and pass it in the DateTime constructor
$timezone = new DateTimeZone('Singapore');
$datetime = new DateTime("today", $timezone);
print_r($datetime);
// date_default_timezone_set('America/Los_Angeles');
//$script_tz = date_default_timezone_get();

echo "\n ------- Format --------- \n";
$now = new DateTime();
$format = $now -> format("d-m-Y");
print_r($format);
echo "\n";
print_r($now->format('jS F Y'));
echo "\n";
print_r($now->format('ga jS M Y'));
echo "\n";
print_r($now->format('Y/m/d s:i:H'));
echo "\n";

echo "\n --------- Comparison --------- \n";
// For comparing two times we dont need to change them to microseconds format using strtotime we can directly compare two DateTime objects
$today = new DateTime('today');
$yesterday = new DateTime('yesterday');

var_dump($today > $yesterday);
var_dump($today < $yesterday);
var_dump($today == $yesterday);

echo "\n ----------- Difference ----------- \n";
// Difference between two dates
$interval = $today->diff($yesterday); // returns DateInterval object which can be used with modify and add methods
print_r($interval);
echo "\n";
echo $interval->format('%d day ago');
echo "\n";
//P7Y5M4DT4H3M2S -> P signifies the start of period for day and T specifies the start of time.
$dateInterval = new DateInterval("P2D");
print_r($dateInterval);
echo "\n";
print_r($today -> add($dateInterval));
echo "\n";

echo "============ Modification ============ \n";
// can be used to do both add and diff functions. This method modifies and writes it to the datetime object directly
$today = new DateTime('today');

echo $today->format('Y-m-d') . PHP_EOL;
echo "\n";
$today->modify('-2 days');
echo $today->format('Y-m-d') . PHP_EOL;
echo "\n";
$today->modify('+2 days');
print_r($today);
// one of the predefined constant using which datetime can generate a date time object.
echo DateTime::ATOM;
echo "\n";
echo DateTime::COOKIE;
echo "\n";

echo "\n ============== Date Create Format ============= \n";
// Converts datetime string not date to required format
$date = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
echo $date->format('Y-m-d');
echo "\n";
$date = date_create_from_format('j-M-Y', '15-Feb-2009');
echo date_format($date, 'Y-m-d');
echo "\n";
echo "\n ========= DateTime::setDate ========= \n";
//Resets the current date of the DateTime object to a different date.
$date = new DateTime();
$date->setDate(2001, 2, 3);
echo $date->format('Y-m-d');
echo "\n";
$date = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
echo $date->format('Y-m-d H:i:sP') . "\n";

$date->setTimezone(new DateTimeZone('Pacific/Chatham'));
echo $date->format('Y-m-d H:i:sP') . "\n";

$date->setTime(14, 55, 24);
echo $date->format('Y-m-d H:i:s') . "\n";

$date->setTimestamp(1171502725);
echo $date->format('U = Y-m-d H:i:s') . "\n";

$date = date_create(); // returns datetime object only
print_r($date);
echo "\n";
date_date_set($date, 2001, 2, 3);
echo date_format($date, 'Y-m-d');
echo "\n";
echo "\n ========= DateTime::setTime ========= \n";
// Resets the current time of the DateTime object to a different time.
$date = new DateTime('2001-01-01');

$date->setTime(14, 55);
echo $date->format('Y-m-d H:i:s') . "\n";
echo "\n";
$date->setTime(14, 55, 24);
echo $date->format('Y-m-d H:i:s') . "\n";
echo "\n";
$date = date_create('2001-01-01');

date_time_set($date, 14, 55, 0);
echo date_format($date, 'Y-m-d H:i:s') . "\n";
echo "\n";
date_time_set($date, 14, 55, 24);
echo date_format($date, 'Y-m-d H:i:s') . "\n";
echo "\n";
echo "\n ===== DateTime::setTimestamp ====== \n";
// Sets the date and time based on an Unix timestamp
$date = new DateTime();
echo $date->format('U = Y-m-d H:i:s') . "\n";
$date->setTimestamp(1171502725);
echo $date->format('U = Y-m-d H:i:s') . "\n";

$date = date_create();
echo date_format($date, 'U = Y-m-d H:i:s') . "\n";

date_timestamp_set($date, 1171502725);
echo date_format($date, 'U = Y-m-d H:i:s') . "\n";

echo " \n ============ DateTime::setTimezone ============== \n";
$date = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
echo $date->format('Y-m-d H:i:sP') . "\n";

$date->setTimezone(new DateTimeZone('Pacific/Chatham'));
echo $date->format('Y-m-d H:i:sP') . "\n";

$date = date_create('2000-01-01', timezone_open('Pacific/Nauru'));
echo date_format($date, 'Y-m-d H:i:sP') . "\n";

date_timezone_set($date, timezone_open('Pacific/Chatham'));
echo date_format($date, 'Y-m-d H:i:sP') . "\n";

echo "\n ========== Date Diff ========== \n";
$today = new DateTime('today');
$yesterday = new DateTime('yesterday');
print_r($today -> diff($yesterday));

print_r(date_diff($today, $yesterday));

echo "\n ========== Date Sub ========== \n";
// Subtracts an amount of days, months, years, hours, minutes and seconds from a DateTime object. Similar to add.
$today = new DateTime('today');
$interval = new DateInterval('P2D');
print_r($today -> sub($interval));

print_r(date_sub($today, $interval));

echo "\n ========== Date Add ========== \n";
$today = new DateTime('today');
$interval = new DateInterval('P2D');
print_r($today -> add($interval));

print_r(date_add($today, $interval));

echo "\n ===== Date Get Last Errors ===== \n";
try {
    $date = new DateTime('asdfasdf');
} catch (Exception $e) {
    // For demonstration purposes only...
    print_r(DateTime::getLastErrors());

    // The real object oriented way to do this is
    // echo $e->getMessage();
}

echo "\n ============= DateTime::getOffset ============= \n";
// Returns the timezone offset in seconds from UTC on success or FALSE on failure.
$today = new DateTime("today");
echo $today -> getOffset();
echo "\n";
$yesterday = new DateTime("yesterday");
echo $yesterday -> getOffset();
echo "\n";
$winter = new DateTime('2010-12-21', new DateTimeZone('America/New_York'));
$summer = new DateTime('2008-06-21', new DateTimeZone('America/New_York'));
echo $winter->getOffset() . "\n";
echo $summer->getOffset() . "\n";

$winter = date_create('2010-12-21', timezone_open('America/New_York'));
$summer = date_create('2008-06-21', timezone_open('America/New_York'));

echo date_offset_get($winter) . "\n";
echo date_offset_get($summer) . "\n";
echo "\n ========= DateTime::getTimestamp ============== \n ";
$date = new DateTime();
echo $date->getTimestamp();
echo "\n";
$date = date_create();
echo date_timestamp_get($date);
echo "\n ========= DateTime::getTimezone ============== \n ";
$date = new DateTime();
$timezone = $date->getTimezone();
print_r($timezone);
$date = date_create();
$timezone = date_timezone_get($date);
print_r($timezone);

echo "\n";
$date = date_create();
echo date_timestamp_get($date);

echo "\n ======= Date Modify ======== \n";
$date = new DateTime('2006-12-12');
$date->modify('+1 day');
echo $date->format('Y-m-d');
echo "\n";
$date = date_create('2006-12-12');
date_modify($date, '+1 day');
echo date_format($date, 'Y-m-d');

echo "\n";
/**
 * So new DateTime() == date_create(). These methods will create a new data with current timestamp.
 * $date -> format() == date_format()
 * DateTime::createFromFormat == date_create_from_format()
 * DateTime::setTime == date_time_set()
 * DateTime::setTimestamp == date_timestamp_set()
 * DateTime::setTimezone == date_timezone_set()
 * new DateTimeZone() == timezone_open()
 * DateTime::getOffset == date_offset_get()
 * DateTime::getTimezone == date_timezone_get()
 * $date->modify == date_modify()
 */

echo "\n ======= Money Format ========= \n";
/* Money Format accepts only two parameters 1.Format and 2.Floating Number
 * The format specification consists of the following sequence:

a % character

optional flags

optional field width

optional left precision

optional right precision

a required conversion character ---- REQUIRED
 */

$number = 1234.56;

// let's print the international format for the en_US locale
setlocale(LC_MONETARY, 'en_US');
echo money_format('%i', $number) . "\n";
// USD 1,234.56

// Italian national format with 2 decimals`
setlocale(LC_MONETARY, 'it_IT');
echo money_format('%.2n', $number) . "\n";
// Eu 1.234,56

// Using a negative number
$number = -1234.5672;

/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

/* Output: vrijdag 22 december 1978 */
echo strftime("%A %e %B %Y", mktime(0, 0, 0, 12, 22, 1978))."\n";

/* try different possible locale names for german */
$loc_de = setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
echo "Preferred locale for german on this system is '$loc_de'\n";

// US national format, using () for negative numbers
// and 10 digits for left precision
setlocale(LC_MONETARY, 'en_US');
echo money_format('%(#10n', $number) . "\n";
// ($        1,234.57)

// Similar format as above, adding the use of 2 digits of right
// precision and '*' as a fill character
echo money_format('%=*(#10.2n', $number) . "\n";
// ($********1,234.57)

// Let's justify to the left, with 14 positions of width, 8 digits of
// left precision, 2 of right precision, withouth grouping character
// and using the international format for the de_DE locale.
setlocale(LC_MONETARY, 'de_DE');
echo money_format('%=*^-14#8.2i', 1234.56) . "\n";
// Eu 1234,56****

// Let's add some blurb before and after the conversion specification
setlocale(LC_MONETARY, 'en_GB');
$fmt = 'The final value is %i (after a 10%% discount)';
echo money_format($fmt, 1234.56) . "\n";
// The final value is  GBP 1,234.56 (after a 10% discount)

/*
 * Flags

One or more of the optional flags below can be used:

=f
The character = followed by a (single byte) character f to be used as the numeric fill character. The default fill character is space.

^
Disable the use of grouping characters (as defined by the current locale).

+ or (
Specify the formatting style for positive and negative numbers. If + is used, the locale's equivalent for + and - will be used. If ( is used, negative amounts are enclosed in parenthesis. If no specification is given, the default is +.

!
Suppress the currency symbol from the output string.

-
If present, it will make all fields left-justified (padded to the right), as opposed to the default which is for the fields to be right-justified (padded to the left).

Field width

w
A decimal digit string specifying a minimum field width. Field will be right-justified unless the flag - is used. Default value is 0 (zero).

Left precision

#n
The maximum number of digits (n) expected to the left of the decimal character (e.g. the decimal point). It is used usually to keep formatted output aligned in the same columns, using the fill character if the number of digits is less than n. If the number of actual digits is bigger than n, then this specification is ignored.

If grouping has not been suppressed using the ^ flag, grouping separators will be inserted before the fill characters (if any) are added. Grouping separators will not be applied to fill characters, even if the fill character is a digit.

To ensure alignment, any characters appearing before or after the number in the formatted output such as currency or sign symbols are padded as necessary with space characters to make their positive and negative formats an equal length.

Right precision

.p
A period followed by the number of digits (p) after the decimal character. If the value of p is 0 (zero), the decimal character and the digits to its right will be omitted. If no right precision is included, the default will dictated by the current local in use. The amount being formatted is rounded to the specified number of digits prior to formatting.

Conversion characters

i
The number is formatted according to the locale's international currency format (e.g. for the USA locale: USD 1,234.56).

n
The number is formatted according to the locale's national currency format (e.g. for the de_DE locale: EU1.234,56).

%
Returns the % character.


 */

// nl_langinfo — Query language and locale information
// nl_langinfo() is used to access individual elements of the locale categories. Unlike localeconv(), which returns all of the elements, nl_langinfo() allows you to select any specific element.

echo "\n ============ parse_str ============ \n";
// Because variables in PHP can't have dots and spaces in their names, those are converted to underscores. Same applies to naming of respective key names in case of using this function with result parameter.
parse_str("My Value=Something");
echo $My_Value; // Something
echo "\n";
parse_str("My Value=Something", $output);
echo $output['My_Value']; // Something
echo "\n";

// till & one chunk is considered , then left to = is variable and right to it is its value. We can even use arrays in this.
$str = "first=value&arr[]=foo+bar&arr[]=baz";

// Recommended
parse_str($str, $output);
echo $output['first'];  // value
echo "\n";
echo $output['arr'][0]; // foo bar
echo "\n";
echo $output['arr'][1]; // baz
echo "\n";



echo PHP_EOL;
echo "------------- PARSE URL -------------------";
echo PHP_EOL;
$url = 'http://username:password@hostname:9090/path?arg=value#anchor';

var_dump(parse_url($url));
var_dump(parse_url($url, PHP_URL_SCHEME));
var_dump(parse_url($url, PHP_URL_USER));
var_dump(parse_url($url, PHP_URL_PASS));
var_dump(parse_url($url, PHP_URL_HOST));
var_dump(parse_url($url, PHP_URL_PORT));
var_dump(parse_url($url, PHP_URL_PATH));
var_dump(parse_url($url, PHP_URL_QUERY));
var_dump(parse_url($url, PHP_URL_FRAGMENT));

echo "\n ===== quoted_printable_encode =========== \n";
// this is mainly used for mails
function quoted_printables_encode($string) {
    return preg_replace('/[^\r\n]{73}[^=\r\n]{2}/', "$0=\r\n",
        str_replace("%", "=", str_replace("%0D%0A", "\r\n",
            str_replace("%20"," ",rawurlencode($string)))));
}
echo quoted_printables_encode("this + @ ! # $ % ^ & * ( ) _ %20 <html>is a new string to be quoted</html>");
echo "\n";
echo quoted_printable_encode("this + @ ! # $ % ^ & * ( ) _ %20 = . \  ' \" | \\ ? / ~ ` \t \n ] } <html>is a new string to be quoted</html>");
echo "\n";
echo " =============== Decode =============== \n";
echo quoted_printable_decode("this + @ ! # $ % ^ & * ( ) _ %20 = . \  ' \" | \\ ? / ~ ` \t \n ] } <html>is a new string to be quoted</html>");
echo "\n";
echo quoted_printable_decode("this + @ ! # $ % ^ & * ( ) _ %20 =3D . \  ' \" | \ ? / ~ ` =09 =0A ] } <html=
>is a new string to be quoted</html>
");
echo "\n";
echo quoted_printable_decode("this is a new string to be quoted");
echo "\n";

echo "\n ========= Quote Meta ================= \n";
// Returns a version of str with a backslash character (\) before every character that is among these:
//. \ + * ? [ ^ ] ( $ )
$str = "Hello world. (can you hear me?)";
echo quotemeta($str);
echo "\n";

echo "\n ============ Str Get CSV ============== \n";
// this function can be used to break any text or file based on desired format. Its not necessarily for csv file.
//array str_getcsv ( string $input [, string $delimiter = "," [, string $enclosure = '"' [, string $escape = "\\" ]]] ). Because the default delimiter value is , that's why its called str_getcsv.
//Returns an indexed array containing the fields read.
print_r(file('/home/kushagra/books.csv'));
$csv = array_map('str_getcsv', file('/home/kushagra/books.csv'));
echo "\n";
echo "\n ============= CSV PARSED ============ \n";
//print_r($csv);

$Data = str_getcsv("/home/kushagra/books.csv", "\n"); // parse the rows
foreach($Data as &$Row) $Row = str_getcsv($Row, ";"); // parse the items in rows
echo "\n ====== printing here ========= \n";
// delimiter tells till what point should text be treated as one row or one entry in array and when we hit delimiter the new array entry starts
print_r(str_getcsv(file_get_contents("/home/kushagra/books.csv"))); // this will create a new array entry for every column value
print_r(str_getcsv(file_get_contents("/home/kushagra/books.csv"), "\n")); // this will treat \n only as a breakpoint for new array entry. So now columns will be separated with ','.
print_r(str_getcsv(file_get_contents("/home/kushagra/books.csv"), "\n", "#", "]"));
print_r(str_getcsv(file_get_contents("/home/kushagra/Documents/csv.txt")));

$line = 'Dem##o ^java2s .com. ^ "abc##.jpg"';

$parsed = str_getcsv(
    $line, # Input line
    ' ',   # Delimiter
    '.',   # Enclosure
    '#'   # Escape char
);

print_r( $parsed );

// All three arguments work together
/*
 * Delimiter tells this specific char is supposed to be taken as a break char and new line should start.
 * Enclosure tells that this specific char should be check when starting a new line after delimiter, if found then look for the end until end is found dont break word even if delimiter is encountered.
 * Escape tells that this specific char is supposed to treated as escape char. If encountered then escape the next character
 */
$line = 'field1,field2,field3,"this is field having backslash at end ",anothersomeval';
$line3 = 'field1,field2,field3,"this is field having backslash at end ,anothersomeval';
$line2 = 'field1,field2,field3,"this is field having backslash at end\",anothersomeval';
$arrField = str_getcsv($line, ",", '"', '\\');
$arrField5 = str_getcsv($line3, ",", '"', '\\'); // will not break even when delimiter was encountered
$arrField2 = str_getcsv($line, ",", '"', '#');
$arrField4 = str_getcsv($line2, ",", '"', '\\');
$line = 'field1\t,field2\t,field3,this is f#ield having backslash at end\',anothersomeval';
$arrField3 = str_getcsv($line, ",", '"', '#');
print_r($arrField);
print_r($arrField2);
print_r($arrField3);
print_r($arrField4);
print_r($arrField5);

$line = '"A";"Some \"Stuff\" -&reg; ";"C"';
$token = str_getcsv($line, ';', '"', 'A');
print_r($token);

echo "\n ========== Str Repeat =========== \n";
echo str_repeat("-=", 10);
echo "\n";

echo "\n ========= Rot 13 =========== \n";
echo str_rot13('PHP 4.3.0'); // CUC 4.3.0
echo "\n";

echo "\n ========= Str Shuffle =========== \n";
echo str_shuffle('PHP 4.3.0'); // CUC 4.3.0
echo "\n";

echo "\n ======== Str Split ============= \n";
// chunk_split is also same as splitting with str_split with split_length parameter
print_r(str_split('PHP 4.3.0')); // CUC 4.3.0
echo "\n";
print_r(str_split('PHP 4.3.0', 3)); // CUC 4.3.0
echo "\n";

echo "\n ========== str_word_count =========== \n";
/*
 * Counts the number of words inside string. If the optional format is not specified, then the return value will be an integer representing the number of words found. In the event the format is specified, the return value will be an array, content of which is dependent on the format. The possible value for the format and the resultant outputs are listed below.

For the purpose of this function, 'word' is defined as a locale dependent string containing alphabetic characters, which also may contain, but not start with "'" and "-" characters.
string
The string

format
Specify the return value of this function. The current supported values are:

0 - returns the number of words found
1 - returns an array containing all the words found inside the string
2 - returns an associative array, where the key is the numeric position of the word inside the string and the value is the actual word itself
charlist
A list of additional characters which will be considered as 'word'
 */
$str = "Hello fri3nd, you're
       looking          good today!àáãç3";

print_r(str_word_count($str, 1));
print_r(str_word_count($str, 2));
print_r(str_word_count($str, 0));
echo "\n";
print_r(str_word_count($str, 1, 'àáãç3'));
echo "\n";
echo str_word_count($str); // defaults to 0
echo "\n";

echo "\n ======== Str Compare ======= \n";
// Returns < 0 if str1 is less than str2; > 0 if str1 is greater than str2, and 0 if they are equal. Gives the difference between the strings
$str1 = "apples";
$str2 = "oranges";
var_dump(strcmp($str1, $str2)); // works logically same as comparison operator except comparison operator returns boolean whereas strcmp returns difference between two strings in -ve/+ve
var_dump($str1 > $str2);
echo "\n";
// strcasecmp is case insensitive version of strcmp

echo "\n ======== Str Coll =========== \n";
// Does string comparison which is not binary safe based on the current locale. ONe string might be less than other in one locale but might be greater in other
$a = 'a';
$b = 'A';

print strcmp ($a, $b) . "\n"; // prints 1

setlocale (LC_COLLATE, 'C');
print "C: " . strcoll ($a, $b) . "\n"; // prints 1

setlocale (LC_COLLATE, 'de_DE');
print "de_DE: " . strcoll ($a, $b) . "\n"; // prints -2

setlocale (LC_COLLATE, 'de_CH');
print "de_CH: " . strcoll ($a, $b) . "\n"; // prints -2

setlocale (LC_COLLATE, 'en_US');
print "en_US: " . strcoll ($a, $b) . "\n"; // prints -2

echo "\n ======== strcspn ============ \n";
// returns the length of string from start to end not matching the mask. This function terminates if mask is found .String count till mask is taken . For every check if mask is not found then any character of mask is treated as a mask char and function terminates counting from there
$a = strcspn('abcd',  'apple');
$b = strcspn('abcd',  'banana');
$c = strcspn('hello', 'l');
$x = strcspn('hello', 'l', 1, 3);
$d = strcspn('hello', 'world');
$e = strcspn('abcdhelloabcd', 'abcd', -9);
$f = strcspn('abcdhellabcde', 'abcde', -9, -5);
$g = strcspn('abcdhellabcd', 'abcde', -9, -5);
$h = strcspn('abcdhellabcd', 'jkasdkhaksjhdka', 0, -1);

var_dump($a);
var_dump($b);
var_dump($c);
var_dump($x);
var_dump($d);
var_dump($e);
var_dump($f);
var_dump($g);
var_dump($h);

echo "\n ========== Strip Tags ========== \n";
// This function tries to return a string with all NULL bytes, HTML and PHP tags stripped from a given str.
$text = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
echo strip_tags($text);
echo "\n";

// Allow <p> and <a>
echo strip_tags($text, '<p><a>');
echo "\n";
// stripcslashes — Un-quote string quoted with addcslashes()

echo "\n ========= Strpos =========== \n";
// returns start position of string in another string. Can also specify the offset to start from
$mystring = 'abc';
$findme   = 'a';
$pos = strpos($mystring, $findme);

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}
// stripos is case insensitive variant of strpos

echo "\n ================== Strip Slashes ============ \n";
// removes slashes from string or from the string returned from addslashes
$str = "Is your name O\'reilly?";

// Outputs: Is your name O'reilly?
echo stripslashes($str);
echo "\n";

echo "\n ========= strstr ============ \n";
// returns the string after the first occurrence of string. If third argument is true then returns the string before the first occurrence of string
$email  = 'name@example.com';
$domain = strstr($email, '@');
echo $domain; // prints @example.com

$user = strstr($email, '@', true); // As of PHP 5.3.0
echo $user; // prints name

// stristr is case insensitive version of strstr

echo "\n ====== Str nat cmp =========== \n";
$str1 = "img12.png";
$str2 = "img2.png";
echo strcmp($str2, $str1);
echo "\n";
echo strnatcmp($str2, $str1);
// strnatcasecmp is case insensitive version of strnatcmp

echo "\n ====== strncmp ======= \n";
//Binary safe string comparison of the first n characters
strncmp("xybc","a3234",0); // 0
strncmp("blah123","hohoho", 5); //0
// strncasecmp case insensitive varient of strncmp

echo "\n ========= Strpbrk ========== \n";
// gets the characters after specified chars first match. If two characters are given then which ever character comes first is used
$text = 'This is a Simple text.';

// this echoes "is is a Simple text." because 'i' is matched first
echo strpbrk($text, 'mi');
echo "\n";
// this echoes "Simple text." because chars are case sensitive
echo strpbrk($text, 'S');
echo "\n";
echo strpbrk($text, 'Si'); // here two chars are not considered as 'Si' they will be considered as 'S' and 'i'

echo "\n === strrchr ==== \n";
// Find the last occurrence of a character in a string. If two characters given then only first one is taken os from k: only k is used
$dir = substr(strrchr("c:\work:make", "k:"), 1);
echo $dir;
echo "\n";

// get everything after last newline
echo " -------------------- ";
$text = "Line 1\nLine 2\nLine 3";
$text2 = "This is line. 10 This is new line";
$last = strrchr($text2, '12');
$last2 = substr(strrchr($text, 10), 1 ); // so 10 here is considered as ascii value and its corresponding char is searched which is then placed here chr(10) is new line
echo "\n";
echo $last;
echo "\n";
echo $last2;
echo "\n";
var_dump(chr(10));
echo "\n";

echo "\n ==== strrev ==== \n";
echo strrev("this is a new string.");
echo "\n";

echo "\n ======== strrpos ========== \n";
// strripos case insensitive version of strrpos
echo strpos("this string is a new string.", "string");
echo "\n";
echo strrpos("this string is a new string.", "string");
echo "\n";

echo "\n =========== Strtok ============ \n";
// returns array. Can tokenize string. Actually Splits string based on the set of characters given in second parameter. So if any of the character given in argument two matches the string is split from there
$string = "This is\tan example\nstring";
/* Use tab and newline as tokenizing characters as well  */
$tok = strtok($string, " \n\t");
print_r($tok);
$tok = strtok(" \n\t");
print_r($tok);
$tok = strtok(" \n\t");
print_r($tok);
//Note that only the first call to strtok uses the string argument. Every subsequent call to strtok only needs the token to use, as it keeps track of where it is in the current string. To start over, or to tokenize a new string you simply call strtok with the string argument again to initialize it. Note that you may put multiple tokens in the token parameter. The string will be tokenized when any one of the characters in the argument is found.
while ($tok !== false) {
    echo "Word=$tok\n";
    $tok = strtok(" \n\t");
}

echo "\n ======= sub str replace ============= \n";
// Replace text within a portion of a string. Appends to string if start length is equal to the actual length of string.
echo substr_replace("This is a string", "2", strlen("This is a string"));
echo "\n";
echo substr_replace("This is a string", "#", 2, strlen("This is a string"));
echo "\n";

echo substr_replace("This is a string", "This is a new string which very big", 2, 4);
echo "\n";

echo "\n ============ Sub str count ============= \n";
// counts the occurrences of sub string
$text = 'This is a test';
echo strlen($text); // 14
echo "\n";
echo substr_count($text, 'is'); // 2
echo "\n";
// the string is reduced to 's is a test', so it prints 1
echo substr_count($text, 'is', 3);
echo "\n";

// the text is reduced to 's i', so it prints 0
echo substr_count($text, 'is', 3, 3);
echo "\n";

// generates a warning because 5+10 > 14
echo substr_count($text, 'is', 5, 10);

echo "\n";

// prints only 1, because it doesn't count overlapped substrings
$text2 = 'gcdgcdgcd';
echo substr_count($text2, 'gcdgcd');
echo "\n";

echo "\n ========= substr compare =========== \n";
// compare a sub string from  main string in between the given segment
echo substr_compare("abcde", "bc", 1, 2); // 0
echo "\n";
echo substr_compare("abcde", "de", -2, 2); // 0
echo "\n";

echo substr_compare("abcde", "bcg", 1, 2); // 0
echo "\n";

echo substr_compare("abcde", "BC", 1, 2, true); // 0
echo "\n";

echo substr_compare("abcde", "bc", 1, 3); // 1
echo "\n";

echo substr_compare("abcde", "cd", 1, 2); // -1
echo "\n";

echo substr_compare("abcde", "abc", 5, 1); // warning
echo "\n";

echo "\n ============= wordwrap ============= \n";
// String will be wrapped this does not mean that string will be stripped . This only means that string will be wrapped by default \n new line
// If the cut is set to TRUE, the string is always wrapped at or before the specified width. So if you have a word that is larger than the given width, it is broken apart. (See second example). When FALSE the function does not split the word even if the width is smaller than the word width.
$text = "The quick brown fox jumped over the lazy dog.";
$newtext = wordwrap($text, 20, "<br />\n");

echo $newtext;
echo "\n";
$text = "A very long woooooooooooorddddddddd. Take this now.";
$newtext = wordwrap($text, 8, "\n", true); // this true here wraps the word if its length is greater than width
echo "$newtext\n";
echo "\n";
// this without cut will not break the continuing word even if the width is exceeded. Break will happen from next line.
$newtext = wordwrap($text, 8, "\n", false); // because its false here so the longer word will completely go to next line.

echo "$newtext\n";
echo "\n";


// Stream resolve include path gives. Resolve filename against the include path. Resolve filename against the include path according to the same rules as fopen()/include.
var_dump(stream_resolve_include_path("test.php"));
//The above example will output something similar to:
//string(22) "/var/www/html/test.php"

echo PHP_EOL;
echo "============================= ENV ==================================";
//putenv/getenv, $_ENV, and phpinfo(INFO_ENVIRONMENT) are three completely distinct environment stores. doing putenv("x=y") does not affect $_ENV; but also doing $_ENV["x"]="y" likewise does not affect getenv("x"). And neither affect what is returned in phpinfo().
print "env is: ".$_ENV["USER"]."\n";
print "(doing: putenv fred)\n";
putenv("USER=fred");
print "env is: ".$_ENV["USER"]."\n";
print "getenv is: ".getenv("USER")."\n";
print "(doing: set _env barney)\n";
$_ENV["USER"]="barney";
print "getenv is: ".getenv("USER")."\n";
print "env is: ".$_ENV["USER"]."\n";
// phpomfp env values gets affected by putenv but not by $_ENV
putenv("USER=fred");
phpinfo(INFO_ENVIRONMENT);

/**
 * prints:

env is: dave
(doing: putenv fred)
env is: dave
getenv is: fred
(doing: set _env barney)
getenv is: fred
env is: barney
phpinfo()

Environment

Variable => Value
...
USER => dave
 */

/**
 * urlencode
(PHP 4, PHP 5, PHP 7)

urlencode — URL-encodes string

Description ¶
string urlencode ( string $str )
This function is convenient when encoding a string to be used in a query part of a URL, as a convenient way to pass variables to the next page.
 */
$_ENV['key'] = [1,2,3,45];
var_dump($_ENV['key']);
class a{public function __toString() {return json_encode($this);}}
$newObj = new a;
putenv("a_obj=".(string) $newObj);
echo getenv('a_obj');