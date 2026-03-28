-- Sample data for the quotesdb database
-- Insert Categories (minimum 5)
INSERT INTO categories (category) VALUES
('Wisdom'),
('Inspiration'),
('Motivation'),
('Life'),
('Success');

-- Insert Authors (minimum 5)
INSERT INTO authors (author) VALUES
('Steve Jobs'),
('Albert Einstein'),
('Maya Angelou'),
('Mark Twain'),
('Winston Churchill');

-- Insert Quotes (minimum 25)
-- Steve Jobs quotes
INSERT INTO quotes (quote, author_id, category_id) VALUES
('The only way to do great work is to love what you do.', 1, 4),
('Innovation distinguishes between a leader and a follower.', 1, 3),
('Your time is limited, don\'t waste it living someone else\'s life.', 1, 4),
('The people who are crazy enough to think they can change the world are the ones who do.', 1, 3),
('Quality is more important than quantity.', 1, 5);

-- Albert Einstein quotes
INSERT INTO quotes (quote, author_id, category_id) VALUES
('Imagination is more important than knowledge.', 2, 1),
('Life is like riding a bicycle. To keep your balance, you must keep moving.', 2, 4),
('The important thing is not to stop questioning.', 2, 1),
('Creativity is intelligence having fun.', 2, 2),
('Learn from yesterday, live for today, hope for tomorrow.', 2, 4);

-- Maya Angelou quotes
INSERT INTO quotes (quote, author_id, category_id) VALUES
('I\'ve learned that people will forget what you said, people will forget what you did, but people will never forget how you made them feel.', 3, 4),
('There is no greater agony than bearing an untold story inside you.', 3, 1),
('There is no rain without dark clouds.', 3, 2),
('Do the best you can until you know better. Then when you know better, do better.', 3, 3),
('I sustain myself with the love of family.', 3, 4);

-- Mark Twain quotes
INSERT INTO quotes (quote, author_id, category_id) VALUES
('The secret of getting ahead is getting started.', 4, 5),
('It is never too late to be what you might have been.', 4, 2),
('The two most important days in your life are the day you are born and the day you find out why.', 4, 4),
('If you tell the truth, you don\'t have to remember anything.', 4, 1),
('The man who does not read has no advantage over the man who cannot read.', 4, 1);

-- Winston Churchill quotes
INSERT INTO quotes (quote, author_id, category_id) VALUES
('Success is not final, failure is not fatal: it is the courage to continue that counts.', 5, 5),
('We make a living by what we get, but we make a life by what we give.', 5, 4),
('You have enemies? Good. That means you\'ve stood up for something.', 5, 4),
('To improve is to change; to be perfect is to change often.', 5, 3),
('Never give up on something that you can\'t go a day without thinking about.', 5, 2);
