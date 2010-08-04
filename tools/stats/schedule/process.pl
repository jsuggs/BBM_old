#!/usr/bin/perl -w

use strict;
use URI::Escape;
use HTML::TreeBuilder;
use Data::Dumper;
use DBI;
use utf8;

my @files = <html/*>;
open SCHED, ">sched.txt";

my $found = 0;


foreach my $file (@files) {
    open FILE, $file;
    my $content = join('',<FILE>);
    utf8::decode($content);
    close FILE;
    my $root = HTML::TreeBuilder->new_from_content($content);
    $root = $root->elementify();

    my @tables = $root->find_by_attribute('id','team_schedule');
    #my @td2 = $root->find_by_attribute('id','team_schedule')->find('tbody')->find('td');

    foreach my $table (@tables) {
        my @trs = $table->look_down('_tag','tr','class','');
        foreach my $tr (@trs) {
            my $html = $tr->as_HTML();
            #next;
            if ($html !~ m/Attendance/) {
                my @tds = $tr->find('td');
                my @vals;
                foreach my $td (@tds) {
                    push(@vals,$td->as_HTML());
                }
                print join(',',@vals) , "\n";
            }
        }
        $found = 1;
    }
    last if ($found);
}
close SCHED;

sub trim {
    my $string = shift;
    return '' if not defined $string;

    $string =~ s/^\s+//;
    $string =~ s/\s+$//;

    return $string;
}
