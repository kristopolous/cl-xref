alter table VehicleModelYear add column mushed text;
update VehicleModelYear set mushed = replace(make || model, ' ', '');
create table make('id' INTEGER PRIMARY KEY, 'make' TEXT NULL)

