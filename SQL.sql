CREATE TABLE dtdsup (
    IDDTDSup INT(11) AUTO_INCREMENT NOT NULL,
    IDDSup VARCHAR(25) NOT NULL,
    IDSat VARCHAR(25) NOT NULL,
    IDGrade VARCHAR(25) NOT NULL,
    IDSup VARCHAR(25) NOT NULL,
    Price DOUBLE(30,2) NOT NULL,
    Name VARCHAR(100) NOT NULL,
    PRIMARY KEY (IDDTDSup)
)