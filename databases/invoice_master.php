-- Invoice master

use ciproject;

create table invoice_master (

invoice_id int auto_increment,
invoice_number VARCHAR(60),
invoice_date DATE,
client_id INT,
total_amount DOUBLE,
primary key(invoice_id)

);

INSERT INTO invoice_master (invoice_number, invoice_date, client_id, total_amount) VALUES
('INV001', '2025-01-01', 101, 500.75),
('INV002', '2025-01-02', 102, 320.40),
('INV003', '2025-01-03', 103, 1500.60),
('INV004', '2025-01-04', 104, 245.30),
('INV005', '2025-01-05', 105, 780.90),
('INV006', '2025-01-06', 106, 1020.00),
('INV007', '2025-01-07', 107, 950.25),
('INV008', '2025-01-08', 108, 300.15),
('INV009', '2025-01-09', 109, 600.80),
('INV010', '2025-01-10', 110, 1100.40),
('INV011', '2025-01-11', 111, 450.65),
('INV012', '2025-01-12', 112, 999.90),
('INV013', '2025-01-13', 113, 1200.00),
('INV014', '2025-01-14', 114, 680.25),
('INV015', '2025-01-15', 115, 850.75);


