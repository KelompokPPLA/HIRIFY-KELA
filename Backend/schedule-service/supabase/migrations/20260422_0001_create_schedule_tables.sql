-- Migration: create users, availabilities, bookings tables for schedule-service
-- Generated: 2026-04-22

-- Enable pgcrypto for gen_random_uuid()
create extension if not exists pgcrypto;

-- users table
create table if not exists users (
  id uuid default gen_random_uuid() primary key,
  name text not null,
  email text not null unique,
  password text,
  role text check (role in ('mentor','mentee')) not null,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

-- availabilities table
create table if not exists availabilities (
  id uuid default gen_random_uuid() primary key,
  mentorId uuid references users(id) on delete cascade,
  date text not null,
  startTime text not null,
  endTime text not null,
  isBooked boolean default false,
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

create index if not exists idx_availabilities_mentor_date on availabilities(mentorId, date);

-- bookings table
create table if not exists bookings (
  id uuid default gen_random_uuid() primary key,
  mentorId uuid references users(id) on delete cascade,
  menteeId uuid references users(id) on delete cascade,
  availabilityId uuid references availabilities(id) on delete set null,
  status text default 'pending' check (status in ('pending','accepted','rejected')),
  created_at timestamptz default now(),
  updated_at timestamptz default now()
);

create index if not exists idx_bookings_mentor on bookings(mentorId);
create index if not exists idx_bookings_availability on bookings(availabilityId);

-- trigger to update updated_at
create or replace function trigger_set_timestamp()
  returns trigger as $$
begin
  new.updated_at = now();
  return new;
end;
$$ language plpgsql;

create trigger users_set_timestamp before update on users for each row execute procedure trigger_set_timestamp();
create trigger availabilities_set_timestamp before update on availabilities for each row execute procedure trigger_set_timestamp();
create trigger bookings_set_timestamp before update on bookings for each row execute procedure trigger_set_timestamp();
