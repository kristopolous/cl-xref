alter table VehicleModelYear add column mushed text;
update VehicleModelYear set mushed = replace(make || model, ' ', '');
